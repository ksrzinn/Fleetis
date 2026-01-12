<?php

use Illuminate\Foundation\Http\FormRequest;

class StoreKmFreightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // policy depois
    }

    public function rules(): array
    {
        return [
            'driver_id' => ['required', 'uuid', 'exists:drivers,id'],
            'vehicle_id' => ['required', 'uuid', 'exists:vehicles,id'],
            'region_id'=> ['required', 'uuid', 'exists:regions,id'],
            'km' => ['required', 'numeric', 'gt:0'],
            'reference_date' => ['required', 'date'],
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
            'km.required' => 'A quilometragem é obrigatória',
            'km.gt' => 'A quilometragem deve ser maior que zero',
            'reference_date.required' => 'A data do frete é obrigatória',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('km')) {
            $this->merge([
                'km' => (float) str_replace(',', '.', $this->km),
            ]);
        }
    }
}
