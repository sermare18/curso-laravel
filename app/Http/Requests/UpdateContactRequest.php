<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'required|email',
            'phone_number' => ['required', 'digits:9'],
            'age' => ['required', 'numeric', 'min:1', 'max:255'],
        ];
    }
}
