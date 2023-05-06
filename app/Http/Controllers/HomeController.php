<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Contact::all());
        // Retornamos vista de home y le pasamos como parámetro una lista con todos los contactos que pertenecen al usuario autentificado que la sacamos de la db, esta lista $contacts es llamada desde la vista home
        // Guardamos los datos de la vita home de cada usuario en la cache durante 30 min a no ser que se produzca un añadido, borrado o actualizado (Ver ContactController)
        // Si los datos no se encuentran disponibles en la cache se buscan en la base de datos
        $contacts = Cache::remember(
            "home" . auth()->id(), 
            now()->addMinutes(30), 
            fn () => auth()->user()->contacts()->latest()->take(9)->get()
        );

        return view('home', compact('contacts'));
    }
}
