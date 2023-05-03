<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contact extends Model
{ // Contact es el modelo en MVC
    // protected $table = "contacts"; // No hace falta ya que laravel asume que el nombre de la tabla es el plural del nombre de la clase

    use HasFactory;

    // Para indicarle que campos del objeto tiene que rellenar en la db masivamente (En una sola operación) a través de un array asociativo.
    // Esto significa que cuando se utiliza el método create o fill en un objeto de la clase Contact (En el controlador de Contact),
    // se pueden establecer los valores de estos campos utilizando un arreglo asociativo.
    // Es importante tener en cuenta que si un campo no está incluido en la propiedad $fillable, no se permitirá su asignación masiva.
    protected $fillable = [
        "name",
        "phone_number",
        "age",
        "email",
        "user_id",
        "profile_picture",
    ];

    public function user(){
        // Busca en la tabla usuarios aquel en el que el id coincide con el user_id de la tabla contactos y retorna Illuminate\Database\Eloquent\Relations\BelongsTo del contacto que satisfaga esta condición
        // Si queremos obtener el usuario concreto cuando llamamos a esta función desde otro fichero. habría que hacerlo llamandoa esta función de las siguientes formas:
            // contact::first()->user
            // contact::first()->user()->get()
        return $this->belongsTo(User::class);
    }

    // Los usuarios con el que este contacto se ha compartido (muchos (Usarios) comparten muchos (Contactos))
    // De esta forma sabemos dado un contacto, con quienes (Usuarios) está compartido
    // Especificamos la tabla ya que no hemos seguido la convencción de laravel y la tabla en vez de llamarse contact_user la hemos llamado contact_shares
    public function sharedWithUsers(){
        return $this->belongsToMany(User::class, 'contact_shares');
    }
}
