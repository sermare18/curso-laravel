<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as FacadesResponse;

class ContactController extends Controller
{ // Aquí es donde se va a implementar la lógica para el modelo Eloquent de Contact, se corresponde con controller en MVC
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
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
        $data = $request->validate([
            // Con esto conseguimos validar los datos y si hay errores volver atrás y enviar un mensaje de error automático
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => ['required', 'digits:9'],
            'age' => ['required', 'numeric', 'min:1', 'max:255'],
        ]);

        // Este método estático create de la clase Contact que hereda de Model también previene de las inyecciones SQL
        // Aqui se almacena el contacto en la base de datos
        Contact::create($data);

        // Si hemos conseguido almacenar el contacto en la base de datos, devolvemos el usuario a la vista de home, donde puede ver todos sus contactos
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
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

        return view('contacts.edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            // Con esto conseguimos validar los datos y si hay errores volver atrás y enviar un mensaje de error automático
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => ['required', 'digits:9'],
            'age' => ['required', 'numeric', 'min:1', 'max:255'],
        ]);

        $contact->update($data);

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('home');
    }
}
