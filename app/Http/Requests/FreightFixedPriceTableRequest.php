<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreightFixedPriceTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation(): void
    {
        if ($this->has('fixed_value')) {
            $this->merge([
                'fixed_value' => $this->normalizeMoney($this->fixed_value),
            ]);
        }
    }

    private function normalizeMoney(string $value): float
    {
        // Remove pontos de milhar e troca vírgula por ponto
        $normalized = str_replace('.', '', $value);
        $normalized = str_replace(',', '.', $normalized);

        return (float) $normalized;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'region_id'    => ['required', 'exists:regions,id'],
            'description'  => ['required', 'string', 'max:255'],
            'fixed_value'  => ['required', 'numeric', 'min:0'],
            'average_km'   => ['nullable', 'integer', 'min:0'],
            'valid_from'   => ['required', 'date'],
            'valid_until'  => ['required', 'date', 'after:valid_from'],
        ];
    }

    public function message(): array
    {
        return [
            'description.required' => 'A descrição é obrigatória',
            'region_id.required' => 'A região é obrigatória',
            'region_id.exists' => 'A região não foi encontrada',
            'fixed_value.required' => 'O valor fixo é obrigatório',
            'fixed_value.numeric' => 'O valor fixo deve ser numérico',
            'fixed_value.min' => 'O valor fixo deve ser maior ou igual a zero',
            'average_km.integer' => 'A média de km deve ser um número inteiro',
            'average_km.min' => 'A média de km deve ser maior ou igual a zero',
            'valid_from.required' => 'A data de início de validade é obrigatória',
            'valid_from.date' => 'A data de início de validade deve ser uma data válida',
            'valid_until.required' => 'A data de término de validade é obrigatória',
            'valid_until.date' => 'A data de término de validade deve ser uma data válida',
            'valid_until.after' => 'A data de término de validade deve ser posterior à data de início de validade',
        ];

    }
}
