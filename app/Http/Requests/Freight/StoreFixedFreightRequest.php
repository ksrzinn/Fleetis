<?php

namespace App\Http\Requests\Freight;

use Illuminate\Foundation\Http\FormRequest;

class StoreFixedFreightRequest extends FormRequest
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
            'vehicle_id' => [
                'required',
                'exists:vehicles,id',
            ],

            'trailer_id' => [
                'nullable',
                'exists:vehicles,id',
            ],

            'driver_id' => [
                'required',
                'exists:drivers,id',
            ],

            'region_id' => [
                'required',
                'exists:regions,id',
            ],

            'freight_fixed_price_id' => [
                'required',
                'exists:freight_fixed_prices,id',
            ],

            'date' => [
                'required',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'vehicle_id.required' => 'O veículo é obrigatório para lançar o frete.',
            'vehicle_id.exists' => 'O veículo informado não existe.',

            'trailer_id.exists' => 'O reboque informado não existe.',

            'driver_id.required' => 'O motorista é obrigatório para lançar o frete.',
            'driver_id.exists' => 'O motorista informado não existe.',

            'region_id.required' => 'A região é obrigatória.',
            'region_id.exists' => 'A região informada não existe.',

            'freight_fixed_price_id.required' => 'O frete fixo é obrigatório.',
            'freight_fixed_price_id.exists' => 'O frete fixo informado não existe.',

            'date.required' => 'A data do frete é obrigatória.',
            'date.date' => 'A data do frete é inválida.',
        ];
    }
}
