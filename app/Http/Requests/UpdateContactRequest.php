<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Llama al método update de ContactPolicy para ver si el usuario autentificado puede realizar la validación de los datos del formulario
        return $this->user()->can('update', $this->contact);
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
                Rule::unique('contacts', 'email')
                    ->where('user_id', auth()->id())
                    ->ignore(request()->route('contact')) // Para que podemos editar el contacto actual sin que nos detecte el email como duplicado, route('contact') obtiene el id del contacto de la ruta 'http://localhost:8000/contacts/44/edit' y dice a la db que si nos encontramos editando ese contacto (id -> 44) que ignore la regla de validación unique
            ],
            'phone_number' => ['required', 'digits:9'],
            'age' => ['required', 'numeric', 'min:1', 'max:255'],
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
