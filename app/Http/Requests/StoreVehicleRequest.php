<?php

namespace App\Http\Requests;

use App\Enums\VehicleStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plate' => [
                'required',
                'string',
                'max:10',
                Rule::unique('vehicles', 'plate')->ignore($this->id),
            ],

            'vehicle_type_id' => [
                'required',
                'exists:vehicle_types,id',
            ],

            'brand' => [
                'nullable',
                'string',
                'max:255',
            ],

            'model' => [
                'required',
                'string',
                'max:255',
            ],

            'year' => [
                'required',
                'integer',
                'min:1980',
                'max:' . now()->year + 1,
            ],

            'current_km' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'region_id' => [
                'required',
                'exists:regions,id',
            ],

            'status' => [
                'required',
                new Enum(VehicleStatus::class),
            ],

            'oil_change_km' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->request->remove('id');
    }
}
