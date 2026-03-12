<?php

namespace App\Http\Requests;

use App\Enums\Persistence;
use App\Enums\PetsPersistence;
use App\Http\Requests\Pets\AlterarFotoPetRequest;
use App\Http\Requests\Pets\CriarPetRequest;
use App\Http\Requests\Pets\EditarPetsRequest;
use App\Http\Requests\Pets\RemoverFotoPetRequest;

class PetsRequest
{
    private BaseValidationRequest $validationRequest;


    public function __construct(
        private array                                $data,
        private readonly Persistence|PetsPersistence $persistence,
        private readonly array                       $attributes = [],
        private readonly ?string                     $guard = null,
    )
    {

        $this->validationRequest = match ($this->persistence) {
            Persistence::CREATE => new CriarPetRequest($this->data, $this->attributes),
            Persistence::UPDATE => new EditarPetsRequest($this->data, $this->attributes),
            PetsPersistence::UPDATE_PHOTO => new AlterarFotoPetRequest($this->data, $this->attributes),
            PetsPersistence::REMOVE_PHOTO => new RemoverFotoPetRequest($this->data, $this->attributes),
        };
    }

    public static function create(array $data, array $attributes = [])
    {
        return new self($data, Persistence::CREATE, $attributes);
    }

    public static function update(array $data, array $attributes = [])
    {
        return new self($data, Persistence::UPDATE, $attributes);
    }

    public static function updatePhoto(array $data, array $attributes = [])
    {
        return new self($data, PetsPersistence::UPDATE_PHOTO, $attributes);
    }

    public static function removePhoto(array $data = [], array $attributes = [])
    {
        return new self($data, PetsPersistence::REMOVE_PHOTO, $attributes);
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
