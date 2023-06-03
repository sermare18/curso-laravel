<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    // Para que la db se borre en cada test que se ejecute
    use RefreshDatabase;

    // Aquí irán los Tests que depengan de la apliación web

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_store_contacts()
    {
        // Los errores que maneja Laravel de forma automática, como los errores de validación, ahora nos los muestra si es que fallan
        $this->withoutExceptionHandling();

        // Creamos un usuario
        $user = User::factory()->create();

        // Creamos un contacto, el método makeOne(), a diferencia de create(), crea el contacto en memoria, pero no lo mete a la db, ya que el proposito del test es comprobar si el controlador mete bien en la db los contactos creados por los usuarios
        // Sobrescribimos el phone number para que no de problemas la validación
        $contact = Contact::factory()->makeOne([
            'phone_number' => '123456789',
            'user_id' => $user->id,
        ]);

        // Para autentificarse en la aplicacion con el usuario creado por el test, utilizar el método actingAs
        $response = $this->actingAs($user)->post(route('contacts.store'), $contact->getAttributes());

        // Comprobamos que se nos redirige a la ruta home 
        $response->assertRedirect(route('home'));

        // Comprobamos que en la db existe el contacto que hemos guardado
        $this->assertDatabaseCount('contacts', 1);
        
        $this->assertDatabaseHas('contacts', [
            'user_id' => $user->id,
            'name' => $contact->name,
            'email' => $contact->email,
            'age' => $contact->age,
            'phone_number' => $contact->phone_number,
        ]);

    }

    public function test_store_contact_validation() {

        // Creamos un usuario
        $user = User::factory()->create();

        // Creamos un contacto, el método makeOne(), a diferencia de create(), crea el contacto en memoria, pero no lo mete a la db, ya que el proposito del test es comprobar si el controlador mete bien en la db los contactos creados por los usuarios
        // Sobrescribimos el phone number para que no de problemas la validación
        $contact = Contact::factory()->makeOne([
            'phone_number' => 'Wrong phone number',
            'email' => "Wrong email",
            'name' => null,
        ]);

        // Para autentificarse en la aplicacion con el usuario creado por el test, utilizar el método actingAs
        $response = $this->actingAs($user)->post(route('contacts.store'), $contact->getAttributes());

        $response->assertSessionHasErrors(['phone_number', 'email', 'name']);

        $this->assertDatabaseCount('contacts', 0);
    }

    /**
     * @depends test_user_can_store_contacts
     *
     * @return void
     */
    public function test_only_owner_can_update_or_delete_contact() {

        [$owner, $notOwner] = User::factory(2)->create();

        $contact = Contact::factory()->createOne([
            'phone_number' => '123456789',
            'user_id' => $owner->id,
        ]);

        $response = $this
            ->actingAs($notOwner)
            ->put(route('contacts.update', $contact->id), $contact->getAttributes());

        $response->assertStatus(403);

        $response = $this
            ->actingAs($notOwner)
            ->put(route('contacts.destroy', $contact->id), $contact->getAttributes());

        // Otra forma de comprobar el 403
        $response->assertForbidden();

    } 
}
