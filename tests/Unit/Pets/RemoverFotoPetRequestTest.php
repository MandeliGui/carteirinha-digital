<?php

use App\Http\Requests\PetsRequest;
use Tests\TestCase;

uses(TestCase::class);

use Illuminate\Validation\ValidationException;

it('valida a remocao de foto recebendo o id do pet', function () {
    $data = PetsRequest::removePhoto([
        'id' => 1,
    ])->validated();

    expect($data)->toBeArray()->toMatchArray([
        'id' => 1,
    ]);
});

it('falha quando o id nao e informado na remocao da foto', function () {
    expect(fn () => PetsRequest::removePhoto()->validated())->toThrow(ValidationException::class);
});
