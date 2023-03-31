<?php

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Devuelve la vista de contact.blade.php
// Route::get('/contact', fn () => Response::view('contact'));

// Route::post('/contact', function (Request $request) {
//     $data = $request->all();
//     // Dump and die
//     // dd($data);

//     // Para meter los datos directamente a la base de datos (No recomendado, laravel es un framework MVC (Modelo, Vista, Controlador))
//     DB::statement("INSERT INTO contacts (name, phone_number) VALUES (?,?)", [$data["name"], $data["phone_number"]]);
//     return "Contact stored";
// });

