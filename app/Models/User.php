<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    // Estos son traits que nos agregan diversas funciones al modelo User
    use Billable, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Si al crear un modelo no ponemos alguno no pasa nada (ese campo se pone como null), pero si intentamos poner uno que no aparece aqui da error
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'trial_ends_at' => 'datetime',
    ];

    // RELACIONES ELOQUENT
    // Definimos la cardinalidad de la relación entre Usuario y Contacto (uno a muchos)
    // Esta función es usada en el método index de ContactController
    public function contacts(): HasMany
    {
        // Este modelo 'Usuario' tiene muchos objetos del modelo 'Contact'
        // Laravel deduce automáticamente cual es la clave foranea en la tabla contacts, asume que es user + _id, por eso es muy importante tener en cuenta la nomenclatura de Laravel
        return $this->hasMany(Contact::class);
    }

    // Contactos que se han compartido con este usuario (muchos (Usarios) comparten muchos (Contactos))
    // De esta forma sabemos dado un usuario, que contactos han sido compartidos con él
    // Especificamos la tabla ya que no hemos seguido la convencción de laravel y la tabla en vez de llamarse contact_user la hemos llamado contact_shares
    public function sharedContacts(){
        return $this->belongsToMany(Contact::class, 'contact_shares');
    }
}
