<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $testUser = User::factory()->hasContacts(30)->createOne(['email' => 'prueba@gmail.com']);
        // Creamos 3 usuarios con 5 contactos cada uno
        // El método hasContacts() no esta definido en ninguna parte, es parte de la "magia" de Laravel, esto es posible porque el modelo User tiene una relación contacts() : hasMany
        // Hacemos que todos los usuarios su primer contacto este compartido con testUser
        $users = User::factory(3)->hasContacts(5)->create()->each(
            fn($user) => $user->contacts()->first()->sharedWithUsers()->attach($testUser->id)
        );

        // Compartimos el primer contacto de testUser con todos los usuarios 
        // pluck('id') devuelve una lista solo con los ids de los usuarios
        $testUser->contacts()->first()->sharedWithUsers()->attach($users->pluck('id'));
    }
}
