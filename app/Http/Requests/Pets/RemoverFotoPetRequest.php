<?php

namespace App\Http\Requests\Pets;

use App\Http\Requests\BaseValidationRequest;
use Illuminate\Support\Facades\Validator;

class RemoverFotoPetRequest extends BaseValidationRequest
{
    public function __construct(private array $data, array $attributes = [])
    {
        parent::__construct($attributes);

        $this->prepareForValidation();
    }

    public function prepareForValidation(): void
    {
        $this->data = [
            'id' => data_get($this->data, 'id'),
        ];
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:tb_pets,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'exists'   => 'O pet com o ID fornecido não existe.',
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
        ];
    }

    public function validated(): array
    {
        return Validator::make($this->data, $this->rules(), $this->messages(), $this->attributes())->validated();
    }
}
