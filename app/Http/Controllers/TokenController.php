<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class TokenController extends Controller
{
    public function create()
    {
        return view('tokens.create');
    }

    public function store(Request $request)
    {
        // Destructuramos el array para covertirlo en una variable ($name), ya que la función validate() nos devuelve un array 
        ['name' => $name] = $request->validate(['name' => 'required|string']);

        $token = $request->user()->createToken($name);
 
        return view('tokens.show', compact('token'));
    }
}
