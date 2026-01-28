<?php

namespace App\Http\Requests\Freight;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFixedFreightRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'driver_id' => [
                'sometimes',
                'exists:drivers,id',
            ],

            'trailer_id' => [
                'nullable',
                'exists:vehicles,id',
            ],

            'date' => [
                'sometimes',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'driver_id.exists' => 'O motorista informado não existe.',

            'trailer_id.exists' => 'O reboque informado não existe.',

            'date.date' => 'A data informada é inválida.',
        ];
    }
}
