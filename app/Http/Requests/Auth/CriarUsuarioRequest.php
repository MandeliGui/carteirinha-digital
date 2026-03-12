<?php

namespace App\Http\Requests\Auth;

use App\Enums\TipoUsuario;
use App\Http\Requests\BaseValidationRequest;
use Illuminate\Validation\Rules\Enum;

class CriarUsuarioRequest extends BaseValidationRequest
{
    public function __construct(private array $data, array $attributes = [])
    {
        parent::__construct($attributes);

        $this->prepareForValidation();
    }

    public function prepareForValidation(): void
    {

        $this->data = [
            "name"        => data_get($this->data, "name"),
            "email"       => data_get($this->data, "email"),
            "password"    => data_get($this->data, "password"),
            "tipoUsuario" => data_get($this->data, "tipoUsuario", TipoUsuario::TUTOR->value),
        ];

    }

    public function rules(): array
    {
        return [
            "name"        => ['required', 'string', 'max:255'],
            "email"       => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            "password"    => ['required', 'string', 'min:8'],
            "tipoUsuario" => ['required', 'string', new Enum(TipoUsuario::class)],
        ];
    }

    public function messages(): array
    {
        return [
            "required"  => "O campo :attribute é obrigatório.",
            "string"    => "O campo :attribute deve ser uma string.",
            "email"     => "O campo :attribute deve ser um endereço de email válido.",
            "max"       => "O campo :attribute deve ter no máximo :max caracteres.",
            "min"       => "O campo :attribute deve ter no mínimo :min caracteres.",
            "unique"    => "O campo :attribute já está em uso.",
            Enum::class => "O campo :attribute da comanda não é válido.",
        ];
    }

    public function validated(): array
    {
        return \Validator::make($this->data, $this->rules(), $this->messages(), $this->attributes())->validated();
    }
}
