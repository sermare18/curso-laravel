<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactShareController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Si estamos autentificados redirigimos a home en caso contrario devolvemos la vista de welcome
Route::get('/', fn() => auth()->check() ? redirect('/home') : view('welcome'));

Auth::routes();

// Ruta que comprueba si tenemos una subscripción activa
// config('stripe.price_id')) : Accedemos a config/stripe.php y obtenemos del array asociativo el valor de la clave 'price_id'
// Que es el identidicador de la subscripción
// Esto nos devuelve a una pagina de stripe donde podemos empezar a pagar por este producto
Route::get('/checkout', [StripeController::class, 'checkout'])->name('checkout');

// Ruta al billing-portal de stripe (Donde se administran las subscripciones en curso)
Route::get('/billing-portal', [StripeController::class, 'billingPortal'])->name('billing-portal');

Route::get('/free-trial-end', [StripeController::class, 'freeTrialEnd'])->name('free-trial-end');

// Agrupamos bajo unos mismos middlewares varias rutas
Route::middleware(['auth','subscription'])->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Con esta única línea de código se generan todas las rutas que hemos definido arriba si y solo si queremos ceñirnos a la convección de rutas de Laravel (Ver documentación)
    // Añadimos el middleware de autentificación para que no seamos capaces de llegar hasta el controlador ContactController
    // sin antes estar autentificado
    // Los nombres de los middlewares estan registrados en app/Http/Kernel.php
    Route::resource('contacts', ContactController::class);
    // Con el except evitamos que nos cree rutas para las funciones que hemos quitado
    Route::resource('contact-shares', ContactShareController::class)
        ->except('show', 'edit', 'update');
    Route::resource('tokens', TokenController::class)->only(['create', 'store']);
});

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
// Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create'); //Ya no nos hace falta poner /contacts/create, sino que únicamente ponemos el nombre de ruta 'contacts.create'
// Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store'); // name() -> esto asigna un nombre a la ruta. En este caso, el nombre de la ruta es 'contacts.store'. Este nombre se utiliza para generar URL y redireccionamientos en Laravel. Lo utilizamos en la vista contact en el campo action del formulario despues de un POST
// Route::get('/contacts/{contact}/', [ContactController::class, 'show'])->name('contacts.show');
// Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit'); 
// Route::put('/contacts/{contact}/', [ContactController::class, 'update'])->name('contacts.update');  
// Route::delete('/contacts/{contact}/', [ContactController::class, 'destroy'])->name('contacts.destroy');
// Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');



