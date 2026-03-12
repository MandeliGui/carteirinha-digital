<?php

use App\Http\Controllers\PetsController;
use Illuminate\Http\Request;
use Tests\TestCase;

uses(TestCase::class);

it('registra a rota de update de pets na api', function () {
    $route = app('router')->getRoutes()->match(Request::create('/api/pets/editar/123', 'PUT'));

    expect($route->getActionName())->toBe(PetsController::class.'@update')
        ->and($route->parameter('id'))->toBe('123');
});

it('registra a rota de alterar foto de pets na api', function () {
    $route = app('router')->getRoutes()->match(Request::create('/api/pets/alterar-foto/123', 'POST'));

    expect($route->getActionName())->toBe(PetsController::class.'@alterarFoto')
        ->and($route->parameter('id'))->toBe('123');
});

it('registra a rota de remover foto de pets na api', function () {
    $route = app('router')->getRoutes()->match(Request::create('/api/pets/remover-foto/123', 'DELETE'));

    expect($route->getActionName())->toBe(PetsController::class.'@removerFoto')
        ->and($route->parameter('id'))->toBe('123');
});
