<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Lo podemos dejar en true para que todos los usuarios puedan validar la información de crear contacto, ya que si posteriormente el usuario no esta autentificado después de validar los datos va a saltar un error debido a las politicas establecidas en ContactPolicy
        // return true;

        // Comprobamos que el usuario que va a validar el formulario de creación de contacto este autentificado
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
                // Con esto conseguimos validar los datos y si hay errores volver atrás y enviar un mensaje de error automático
                'name' => 'required',
                'email' => [
                    'required',
                    'email',
                    // Creamos nuestra propia regla de validación
                    Rule::unique('contacts', 'email')->where('user_id', auth()->id())
                ],
                'phone_number' => ['required', 'digits:9'],
                'age' => ['required', 'numeric', 'min:1', 'max:255'],
                'profile_picture' => 'image|nullable',
        ];
    }

    // Con esta función sobreescribimos los mensajes por defecto que manda Laravel
    public function messages()
    {
        return [
            // Para el campo 'email' en su regla de validación 'unique'
            'email.unique' => 'You already have a contact with this email'
        ];
    }
}
