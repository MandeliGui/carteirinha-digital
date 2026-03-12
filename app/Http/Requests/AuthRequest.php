<?php

namespace App\Http\Requests;

use App\Enums\Persistence;
use App\Http\Requests\Auth\CriarUsuarioRequest;


class AuthRequest
{
    private BaseValidationRequest $validationRequest;


    public function __construct(
        private array                $data,
        private readonly Persistence $persistence,
        private readonly array       $attributes = [],
        private readonly ?string     $guard = null,
    )
    {

        $this->validationRequest = match ($this->persistence) {
            Persistence::CREATE => new CriarUsuarioRequest($this->data, $this->attributes),


        };
    }

    public static function create(array $data, array $attributes = [])
    {
        return new self($data, Persistence::CREATE, $attributes);
    }

    public function attributes()
    {
        return $this->attributes;
    }

    public function validated()
    {
        return $this->validationRequest->validated();
    }
}
