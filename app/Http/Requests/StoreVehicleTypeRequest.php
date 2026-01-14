<?php

namespace App\Http\Requests;

use App\Enums\VehicleType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreVehicleTypeRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:vehicle_types,name'],
            'type' => ['required', new Enum(VehicleType::class)],
            'description' => ['nullable', 'string'],
            'truck_axles' =>['required', 'integer', 'min:0'],
            'oil_change_km' => ['nullable', 'integer', 'min:0']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é esperado.',
            'name.unique' => 'Já existe um tipo de veículo com esse nome.',
            'name.string' => 'O nome deve ser alfanumérico',
            'type.required' => 'A modalidade do veículo é esperada.',
            'type.enum' => 'Tipo de veículo inválido.',
            'truck_axles.required' => 'A quantidade de eixos é esperada.',
            'truck_axles.min' => 'A quantidade de eixos deve ser superior a 0.',
            'oil_change_km' => 'A quantidade de KMs antes da troca de óleo deve ser superior a 0.'

        ];
    }
}
