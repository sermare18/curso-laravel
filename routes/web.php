<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;
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

// Devuelve la vista de contact.blade.php
Route::get('/contact', fn () => Response::view('contact'));

Route::post('/contact', function (Request $request) {
    // Dump and die
    dd($request);
});

Route::get('/change-password', fn () => Response::view('change-password'));

Route::post('/change-password', function (Request $request) {
    // Función que devuelve booleano indicando si el usuario está autentificado, es decir, si ha iniciado sesión
    // Equivalente a auth()->check(), sin necesidad de importar el fachade Auth
    if (Auth::check()) {
        // Equivalente a: return new response("Authenticated")
        return new HttpResponse("Password Changed to {$request->get('password')}");
    } else {
        return (new HttpResponse("Not Authenticated", 401));
    }
});
