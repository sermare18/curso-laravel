<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

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
        return view('home', ['contacts' => auth()->user()->contacts()->latest()->take(9)->get()]);
    }
}
