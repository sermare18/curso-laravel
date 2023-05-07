<?php

use App\Http\Resources\ContactResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Probar en la terminal el siguiente comando: curl -H "Authorization: Bearer 7|VpPsyehrxx7GvFFqbbTJF89qcbfSqK5M4DGvMnhr" http://localhost:8000/api/user
// Probar en la terminal el siguiente comando: curl -H "Authorization: Bearer 7|VpPsyehrxx7GvFFqbbTJF89qcbfSqK5M4DGvMnhr" http://localhost:8000/api/contacts

// A la hora de escalar esta aplicación lo recomendable sería dividir la carpeta 'Controllers' en dos subcarpetas 'web' y 'Api'
// y en vez de escribir todo esto: 'Route::get('/contacts', fn (Request $request) => ContactResource::collection($request->user()->contacts));'
// únicamnte tendriamos que poner: 'Route::apiResource()' y pasarle como parámetro el método y el controlador respectivo
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());
    Route::get('/contacts', fn (Request $request) => ContactResource::collection($request->user()->contacts));
});
