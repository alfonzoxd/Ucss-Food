<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'ends_with:ucss.pe', // Mantenemos la regla de negocio UCSS
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    /**
     * Mensajes personalizados (Opcional)
     */
    public function messages(): array
    {
        return [
            'email.ends_with' => 'Debes mantener un correo institucional (@ucss.pe).',
        ];
    }
}
