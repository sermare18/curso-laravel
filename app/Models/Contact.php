<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contact extends Model
{ // Contact es el modelo en MVC
    // protected $table = "contacts"; // No hace falta ya que laravel asume que el nombre de la tabla es el plural del nombre de la clase

    use HasFactory;

    // Para indicarle que campos del objeto tiene que rellenar en la db sin que introduzca todos
    // Esto significa que cuando se utiliza el método create o fill en un objeto de la clase Contact (En el controlador de Contact),
    // se pueden establecer los valores de estos campos utilizando un arreglo asociativo.
    protected $fillable = [
        "name",
        "phone_number",
        "age",
        "email",
    ];
}
