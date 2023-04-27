<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{ // Aquí es donde se va a implementar la lógica para el modelo Eloquent de Contact, se corresponde con controller en MVC
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$contacts = Contact::query()->where('user_id', '=', auth()->id())->get();
        // Otra forma: llamamos al método contacts que hemos creado en el modelo User. (Parece que da error, pero en realidad está bien)
        $contacts = auth()->user()->contacts()->get();
        // La línea de arriba es equivalente a $contacts = auth()->user()->contacts; 

        // Retornamos vista del index y le pasamos como parámetro una lista con todos los contactos que la sacamos de la db, esta lista $contacts es llamada desde la vista index
        return view('contacts.index', compact('contacts')); // compact('contacts') crea un array asociativo con nombre 'contacts' y contenido el contenido de la variable $contacts
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Devolvemos la vista de crear contacto
        // La vista de crear contacto se encuentra dentro de la carpeta views en la subcarpeta contacts, aqui esta el fichero create.blade.php
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        //Almacenamos el nuevo contacto en la base de datos

        // if (is_null($request->get('name'))){
        //     // LARAVEL ES MUY EXPRESIVO, una misma cosa se puede hacer de muchas formas
        //     // Redirigimos a la vista de crear contacto y metemos en la sesión los errores
        //     // Equivalente con 'funciones helper' a return response()->redirectTo('contacts/create')->withErrors
        //     // También equivalente con 'funciones helper' a return redirect('contacts/create')->withErrors
        //     // O accediendo a la ruta con el nombre de ruta return redirect(route('contacts.create'))->withErrors
        //     // Otra opción para volver atrás sin poner rutas: return redirect()->back()->withErrors
        //     // O return back()->withErrors
        //     return FacadesResponse::redirectTo('contacts/create')->withErrors([
        //         'name' => 'This field is required', // Este es el mensaje donde se guarda la información del error y lo podemos extraer en el frontend a través de la variable $message
        //     ]);
        // }

        // Aquí vamos a validar desde blade (No desde el navegador) que luego se compila a php (storage/views) los datos que recibimos del formulario
        // Reglas de validación definidas en app/Requests/StoreContactRequest
        $data = $request->validated();

        // Solo podemos ver desde el navegador el contenido que se encuentre en la carpeta public raíz, no la carpeta /storage/app/public
        // Para poder ver las imagenes de los contactos debemos crear un enlace simbólico con el comando 'php artsian storage:link' que comunique la carpeta public/storage
        // Con la carpeta storage/app/public

        // Si no nos ha manddado una imagen ese campo se inicializa a null que se evalua como false en el if
        if (request()->hasFile('profile_picture')) {
            // Con store() guardamos la imagen en el "disco del servidor" en la carpeta storage/app/public/profiles, a la imagen le pone como nombre un hash
            // Esto es porque todas las imagenes deben ser accesibles de forma pública para que el navegador las pueda cargar y renderizar
            // En principio, de esta forma cualquier persona podría ver las imagenes de los contactos de otros usuarios pero para ello tendría 
            // que adivinar el hash de la imagen cosa muy improbable. A esta ruta con el hash solo tienen acceso cada usuario de contactsApp desde la db
            // Obtenemos la ruta (path) de la imagen de perfil del usuario y la guardamos dentro de la variable $path

            // Si no queremos que los ficheros sean accesibles de forma publica quitamos el parámetro public del método store()
            // Y estos ficheros solo podrán ser accedidos por la persona que tenga control sobre el servidor.
            // Ya que por ejemplo estas ficheros (imagenes) se guardarían en storage/app/profiles que no esta enlazado con el enlace simbólico
            // a public/storage.
            $path = $request->file('profile_picture')->store('profiles', 'public');
            // Almacenamos en la base de datos el path donde se encuentra la imagen
            $data['profile_picture'] = $path;
        }

        // Para que nos devuelva la URL completa de cómo acceder desde el navegador a este archivo
        // En este caso solo nos devuelve una uri porque no tiene protocolo, esto es debido a que estamos trabajando en local
        // Esto se puede ver en el fichero .env en el campo FILESYSTEM_DISK=local
        // dd(Storage::url($path));

        // Guardamos en data el id del usuario autentificado que va a crear su contacto, con auth()->id() obtiene el ID del usuario autenticado actualmente a través de los datos de sesión.
        $data['user_id'] = auth()->id();

        // Este método estático create de la clase Contact que hereda de Model también previene de las inyecciones SQL
        // Aqui se almacena el contacto en la base de datos
        $contact = Contact::create($data);

        // Otra posibilidad sin tener que incluir en $data el campo 'user_id' es: auth()->user()->contacts()->create($data)

        // Enviamos mensaje flash (Ver app.blade.php)
        // En vez de put(), utilizamos el método flash() para que la información se mantenga únicamente en el siguiente request
        // session()->flash('alert', [
        //     'message' => "Contact $contact->name successfully saved",
        //     'type' => 'success',
        // ]);

        // Si hemos conseguido almacenar el contacto en la base de datos, devolvemos el usuario a la vista de home, donde puede ver todos sus contactos
        return redirect('home')->with('alert', [
            'message' => "Contact $contact->name successfully saved",
            'type' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        // Forma de más bajo nivel
        // abort_if($contact->user_id !== auth()->id(), 403);

        // Con gates (Puertas), implementando el método boot de app/Providers/AuthServiceProvider
        // if (! Gate::allows('show-contact', $contact)) {
        //     abort(403);
        // }
        // Otra forma oneline sería:
        // Gate::authorize('show-contact', $contact);

        // Tercera forma con politicas de modelos (app/Policies/ContactPolicy, esta política ha sido creada con el comando Php artisan make:policy ContactPolicy —model Contact)
        // De esta forma vamos a app/Providers/AuthServiceProvider y el metodo boot ejecuta: $this->registerPolicies();, que encontrará la politica que hemos creado
        $this->authorize('view', $contact);

        return view('contacts.show', compact('contact')); // Lo mismo que return view('contacts.show', ['contact' => $contact]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        // dd(request()->route('contact')); // imprimirá información sobre la ruta que coincida con el parámetro "contact" en la solicitud actual. Ver el parametro {contact} en web.php
        // Si no encuentra el contacto en la db automáticamente manda un 404
        // $contact = Contact::findOrFail($contactId); // Esto lo hace automáticamente laravel con los parámetros de entrada de esta función (Esto se llama inyección de dependencias)

        $this->authorize('update', $contact);

        return view('contacts.edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $data = $request->validated();

        if (request()->hasFile('profile_picture')) {

            $path = $request->file('profile_picture')->store('profiles', 'public');
            $data['profile_picture'] = $path;
        }

        $contact->update($data);

        return redirect('home')->with('alert', [
            'message' => "Contact $contact->name successfully updated",
            'type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $this->authorize('delete', $contact);

        // Eliminar la foto de perfil del contacto si no es la imagen por defecto
        if ($contact->profile_picture != 'profiles/default.png') {
            Storage::disk('public')->delete($contact->profile_picture);
        }

        $contact->delete();

        return back()->with('alert', [
            'message' => "Contact $contact->name successfully deleted",
            'type' => 'danger',
        ]);
    }
}
