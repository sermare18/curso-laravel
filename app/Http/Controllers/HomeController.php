<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Contact::all());
        // Retornamos vista de home y le pasamos como parámetro una lista con todos los contactos que la sacamos de la db, esta lista $contacts es llamada desde la vista home
        return view('home', ['contacts' => Contact::all()]);
    }
}
