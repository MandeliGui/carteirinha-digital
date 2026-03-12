<?php

use App\Enums\SexoPet;
use App\Http\Requests\PetsRequest;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

uses(TestCase::class);

it('valida os dados de edicao do pet com os campos esperados pelo service', function () {
    $data = PetsRequest::update([
        'id' => 1,
        'nome' => 'Rex',
        'especie' => 'Cachorro',
        'raca' => 'Vira-lata',
        'cor' => 'Caramelo',
        'dataNascimento' => '2022-05-10',
        'sexo' => SexoPet::MASCULINO->value,
        'personalidade' => 'Brincalhao',
        'observacoes' => 'Gosta de passear',
        'animal_chipado' => true,
        'numero_chip' => '123456',
        'peso' => 12.5,
    ])->validated();

    expect($data)->toMatchArray([
        'id' => 1,
        'nome' => 'Rex',
        'especie' => 'Cachorro',
        'raca' => 'Vira-lata',
        'cor' => 'Caramelo',
        'dataNascimento' => '2022-05-10',
        'sexo' => SexoPet::MASCULINO->value,
        'personalidade' => 'Brincalhao',
        'observacoes' => 'Gosta de passear',
        'animalChipado' => true,
        'numeroChip' => '123456',
        'peso' => 12.5,
    ]);
});

it('falha quando os campos obrigatorios da edicao nao sao enviados', function () {
    expect(fn () => PetsRequest::update([
        'cor' => 'Preto',
    ])->validated())->toThrow(ValidationException::class);
});
