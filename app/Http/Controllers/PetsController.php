<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterPaginateRequest;
use App\Http\Requests\PetsRequest;
use App\Services\PetsService;
use Illuminate\Http\Request;

class PetsController extends Controller
{
    public function __construct(
        private PetsService $petsService
    ) {
    }

    public function findAll(FilterPaginateRequest $request)
    {
        return $this->petsService->findAll($request);
    }

    public function create(Request $request)
    {
        $data = PetsRequest::create($request->all())->validated();

        return $this->petsService->create($data);
    }

    public function update(Request $request, PetsService $petsService, int $id)
    {
        $data = PetsRequest::update([
            ...$request->all(),
            'id' => $id,
        ])->validated();

        return $this->petsService->update($data);
    }

    public function alterarFoto(Request $request, int $id)
    {
        $data = PetsRequest::updatePhoto([
            ...$request->allFiles(),
            'id' => $id,
        ])->validated();

        return $this->petsService->alterarFoto($data);
    }

    public function removerFoto(int $id)
    {
        $data = PetsRequest::removePhoto([
            'id' => $id,
        ])->validated();

        return $this->petsService->removerFoto($data);
    }
}
