<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ContactShareController extends Controller
{
    public function index()
    {   
        // Con esto conseguimos que la db nos devuelva los contactos compartidos con el usuario y los usuarios que han compartido estos contactos (Esto ultimo con la relación eloquente 'user' definida en el modelo Contact, que obtiene el usuario que ha creado ese contacto)
        $contactsSharedWithUser = auth()->user()->sharedContacts()->with('user')->get();
        // Contactos que ha compartido el usuario en cuestión, primero cogemos todos los contactos del usuario en cuestión junto a los usuarios que se les ha compartido ese contacto, si el campo 'sharedWithUsers' de la respuesta de la db esta vacío quiere decir que ese contacto no ha sido compartido por el usuario en cuestión y lo descartamos con el filter
        // Comprobar con tinker: User::find(1)->contacts()->with('sharedWithUsers')->get();
        // Aquellos contactos que han sido compartidos dentro del campo 'sharedWithUsers' tienen un subcampo pivot que hace referencia a la tabla de pivote 'contact_shares'
        // Sin embargo, esta tabla pivote solo nos devuelve el user_id y el contact_id para que también nos devuelva el id de esta tabla pivote tenemos que hacer: with(['sharedWithUsers' => fn($query) => $query->withPivot('id')])
        $contactsSharedByUser = auth()
            ->user()
            ->contacts()
            ->with(['sharedWithUsers' => fn ($query) => $query->withPivot('id')])
            ->get()
            ->filter(fn ($contact) => $contact->sharedWithUsers->isNotEmpty());

        return view('contact-shares.index', compact(
            'contactsSharedWithUser',
            'contactsSharedByUser'
        ));
    }

    public function create()
    {
        return view('contact-shares.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_email' => "exists:users,email|not_in:{$request->user()->email}",
            'contact_email' => Rule::exists('contacts', 'email')
                ->where('user_id', auth()->id()),
        ], [
            'user_email.not_in' => "You can't share a contact with yourself",
            'contact_email.exists' => "This contact was not found in yor contact list",
        ]);

        $user = User::where('email', $data['user_email'])->first(['id', 'email']); // Nos quedamos solo con el id del usuario
        $contact = Contact::where('email', $data['contact_email'])->first(['id', 'email']); // Nos quedamos solo con el id del contacto

        // Si el contacto ya ha sido compartido previamente guardamos en $shareExists el usuario al que ya le hemos compartido previamente el contacto
        $shareExists = $contact->sharedWithUsers()->wherePivot('user_id', $user->id)->first();
        // Si $shareExists no es nulo, es decir el contacto ya le habiamos compartido anteriormete con el mismo usuario, se evalua a True
        if ($shareExists){
            return back()->withInput($request->all())->withErrors([
                'contact_email' => "This contact was already shared with user $user->email",
            ]);
        }

        $contact->sharedWithUsers()->attach($user->id);

        return redirect()->route('home')->with('alert', [
            'message' => "Contact $contact->email shared with $user->email successfully",
            'type' => 'success'
        ]);
    }

    public function destroy(int $id)
    {
        // $contactShare = auth()->user()->contacts()->with([
        //     'sharedWithUsers' => fn($query) => $query->where('contact_shares.id', $id)
        // ])->get()->firstWhere(fn ($contact) => $contact->sharedWithUsers->isNotEmpty());

        // abort_if(is_null($contactShare), 404);

        // dd($contactShare);

        // Otra forma de hacer lo mismo que arriba
        $contactShare = DB::selectOne('SELECT * FROM contact_shares WHERE id = ?',[$id]);
        // Si no encuentra el contacto devuelve un 404 NOT FOUND
        $contact = Contact::findOrFail($contactShare->contact_id);
        
        // Comprobar que el contacto sea del usuario en cuestión
        abort_if($contact->user_id !== auth()->id(), 403);

        // Una vez ya comprobado que el contazro pertenece al usuario en cuestión
        $contact->sharedWithUsers()->detach($contactShare->user_id);

        return redirect()->route('contact-shares.index')->with('alert', [
            'message' => "Contact $contact->email unshared successfully",
            'type' => 'success'
        ]);
        
    }
}
