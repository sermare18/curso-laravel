<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// // Devuelve la vista de contact.blade.php
// Route::get('/contact', fn () => Response::view('contact'));

// Route::post('/contact', function (Request $request) {
//     $data = $request->all();
//     // Dump and die
//     // dd($data);

//     // Para meter los datos directamente a la base de datos (No recomendado, laravel es un framework MVC (Modelo, Vista, Controlador))
//     // DB::statement("INSERT INTO contacts (name, phone_number) VALUES (?,?)", [$data["name"], $data["phone_number"]]);

//     //Creamos un objeto de la clase Eloquent que hemos creado usando el comando php artisan make:model Contact
//     // $contact = new Contact();  
//     // $contact->name = $data["name"];
//     // $contact->phone_number = $data["phone_number"];
//     // // Guardamos el contacto en la base de datos
//     // $contact->save();

//     // Otra forma más rápida de inicializar los atributos del objeto Eloquent
//     // Contact es el modelo en MVC
//     Contact::create($data);

//     return "Contact stored";
// });

// Siguiendo los estándares de la documentación oficial de laravel
// La lógica ya no es ruta - función, sino, ruta - controlador - función
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create'); //Ya no nos hace falta poner /contacts/create, sino que únicamente ponemos el nombre de ruta 'contacts.create'
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store'); // name() -> esto asigna un nombre a la ruta. En este caso, el nombre de la ruta es 'contacts.store'. Este nombre se utiliza para generar URL y redireccionamientos en Laravel. Lo utilizamos en la vista contact en el campo action del formulario despues de un POST

