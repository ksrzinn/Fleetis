<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKmRateRequest extends FormRequest
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
            'region_id' => [
                'required',
                'exists:regions,id',
            ],

            'vehicle_type_id' => [
                'required',
                'exists:vehicle_types,id',
            ],

            'price_per_km' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'valid_until' => [
                'required',
            ],

            'valid_from' => [
                'required',
            ],

            'active' => [
                'sometimes',
                'boolean',
            ],
        ];
    }

    public function prepareForValidation()
    {
        $this->request->remove('id');

        $this->merge([
            'active' => $this->active ?? true,
        ]);
    }

    public function messages(): array
    {
        return [
            'region_id.required' => 'A região é obrigatória.',
            'region_id.exists' => 'A região informada é inválida.',

            'vehicle_type_id.required' => 'O tipo de veículo é obrigatório.',
            'vehicle_type_id.exists' => 'O tipo de veículo informado é inválido.',

            'price_per_km.required' => 'O valor por KM é obrigatório.',
            'price_per_km.numeric' => 'O valor por KM deve ser numérico.',
            'price_per_km.min' => 'O valor por KM deve ser maior que zero.',

            'active.boolean' => 'O status informado é inválido.',
        ];
    }
}
