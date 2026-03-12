<?php

use App\Http\Requests\PetsRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

uses(TestCase::class);

it('valida o upload da foto do pet', function () {
    $data = PetsRequest::updatePhoto([
        'id' => 1,
        'foto' => UploadedFile::fake()->image('pet.jpg'),
    ])->validated();

    expect($data['id'])->toBe(1)
        ->and($data['foto'])->toBeInstanceOf(UploadedFile::class)
        ->and($data['foto']->getClientOriginalName())->toBe('pet.jpg');
});

it('falha quando a foto nao e uma imagem valida', function () {
    expect(fn () => PetsRequest::updatePhoto([
        'id' => 1,
        'foto' => UploadedFile::fake()->create('arquivo.pdf', 10, 'application/pdf'),
    ])->validated())->toThrow(ValidationException::class);
});
