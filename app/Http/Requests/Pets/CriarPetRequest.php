<?php

namespace App\Http\Requests\Pets;

use App\Enums\SexoPet;
use App\Http\Requests\BaseValidationRequest;
use Illuminate\Validation\Rules\Enum;

class CriarPetRequest extends BaseValidationRequest
{
    public function __construct(private array $data, array $attributes = [])
    {
        parent::__construct($attributes);

        $this->prepareForValidation();
    }

    public function prepareForValidation(): void
    {
        $this->data = [
            "nome"           => data_get($this->data, "nome"),
            "especie"        => data_get($this->data, "especie"),
            "raca"           => data_get($this->data, "raca"),
            "cor"            => data_get($this->data, "cor"),
            "dataNascimento" => data_get($this->data, "dataNascimento"),
            "sexo"           => data_get($this->data, "sexo"),
            "personalidade"  => data_get($this->data, "personalidade"),
            "observacoes"    => data_get($this->data, "observacoes"),
            "animal_chipado" => data_get($this->data, "animalChipado"),
            "numero_chip"    => data_get($this->data, "numeroChip"),
            "foto"           => data_get($this->data, "foto"),
            "peso"           => data_get($this->data, "peso"),
        ];

    }

    public function rules(): array
    {
        return [
            "nome"           => ['required', 'string'],
            "especie"        => ['required', 'string'],
            "raca"           => ['required', 'string'],
            "cor"            => ['nullable', 'string'],
            "dataNascimento" => ['nullable', 'date'],
            "sexo"           => ['required', 'string', new Enum(SexoPet::class)],
            "personalidade"  => ['nullable', 'string'],
            "observacoes"    => ['nullable', 'string'],
            "animal_chipado" => ['nullable', 'boolean'],
            "numero_chip"    => ['nullable', 'string'],
            "foto"           => ['nullable'],
            "peso"           => ['nullable', 'numeric'],
        ];
    }

    public function messages(): array
    {
        return [
            "required"  => "O campo :attribute é obrigatório.",
            "string"    => "O campo :attribute deve ser uma string.",
            "date"      => "O campo :attribute deve ser uma data válida.",
            Enum::class => "O campo :attribute da comanda não é válido.",
            "numeric"   => "O campo :attribute deve ser um número.",
            "boolean"   => "O campo :attribute deve ser verdadeiro ou falso.",
        ];
    }

    public function validated(): array
    {
        return \Validator::make($this->data, $this->rules(), $this->messages(), $this->attributes())->validated();
    }
}
