<?php

use Illuminate\Foundation\Http\FormRequest;

class StoreKmFreightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; //TODO: verificar com police se o user pode entrar aqui
    }

    public function rules(): array
    {
        return [
            'driver_id' => ['required', 'uuid', 'exists:drivers,id'],
            'vehicle_id' => ['required', 'uuid', 'exists:vehicles,id'],
            'region_id'=> ['required', 'uuid', 'exists:regions,id'],
            'km' => ['required', 'numeric', 'min:0.1'],
        ];
    }

    public function messages(): array
    {
        return [
            'driver_id.required' => 'O motorista é obrigatório',
            'driver_id.exists' => 'O motorista não foi encontrado',
            'vehicle_id.required' => 'O veículo é obrigatório',
            'vehicle_id.exists' => 'O veículo não foi encontrado',
            'region_id.required' => 'A região é obrigatória',
            'region_id.exists' => 'A região não foi encontrada',
            'km.required' => 'O quilometragem é obrigatório',
            'km.min' => 'A quilometragem deve ser maior que zero'
        ];
    }
}
