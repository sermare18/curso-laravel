<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            // Columnas de la tabla contacts
            $table->id();
            $table->string('name');
            $table->string('phone_number');
            $table->string('email');
            $table->tinyInteger('age', unsigned: true);
            $table->foreignIdFor(User::class); // Creamos una clave foranea que apunta al campo id del modelo User. La clave foranea se nombrará automáticamente a user_id (nomenclatura de Laravel)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
