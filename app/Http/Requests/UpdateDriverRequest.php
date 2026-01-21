<?php

namespace App\Http\Requests;

use App\Enums\DriverBonusType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateDriverRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'name'        => ['required', 'string', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'cpf'         => ['required', 'string', "unique:drivers,cpf,$id"],
            'cnh'         => ['required', 'string', "unique:drivers,cnh,$id"],
            'cnh_type'    => ['required', 'string'],

            'salary'      => ['required', 'numeric', 'min:0'],

            'bonus_type'  => ['required', new Enum(DriverBonusType::class)],

            'bonus_value' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attr, $value, $fail) {
                    if (
                        $this->bonus_type !== DriverBonusType::NONE->value
                        && is_null($value)
                    ) {
                        $fail('O valor do bônus é obrigatório quando o tipo não é NONE.');
                    }
                }
            ],
        ];
    }
}
