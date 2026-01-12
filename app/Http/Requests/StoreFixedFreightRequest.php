<?php

use Illuminate\Foundation\Http\FormRequest;

/**
 * Esse Request valida os dados para a entrada de um frete realizado com um frete fixo.
 */
class StoreFixedFreightRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'driver_id' => ['required', 'uuid', 'exists:drivers,id'],
            'vehicle_id' => ['required', 'uuid', 'exists:vehicles,id'],
            'region_id' => ['required', 'uuid', 'exists:regions,id'],

            'freight_fixed_price_table_id' => ['required', 'uuid', 'exists:freight_fixed_price_tables,id']

        ];
    }

    public function message(): array
    {
        return [
            'driver_id.required' => 'O motorista é obrigatório',
            'driver_id.exists' => 'O motorista não foi encontrado',
            'vehicle_id.required' => 'O veículo é obrigatório',
            'vehicle_id.exists' => 'O veículo não foi encontrado',
            'region_id.required' => 'A região é obrigatória',
            'region_id.exists' => 'A região não foi encontrada',
            'freight_fixed_price_table_id.required' => 'O frete é obrigatório',
            'freight_fixed_price_table_id.exists' => 'O frete fixo não foi encontrado'
        ];

    }
}
