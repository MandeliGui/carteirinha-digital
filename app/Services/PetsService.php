<?php

namespace App\Services;

use App\Http\Requests\FilterPaginateRequest;
use App\Models\HistoricoPesoModel;
use App\Models\PetsModel;
use Cloudinary\Cloudinary;
use Str;

class PetsService
{
    public function __construct(
        private Cloudinary $cloudinary
    )
    {
    }

    public function findAll(FilterPaginateRequest $request)
    {
        return PetsModel::query()->with(['tutores', 'peso'])->whereHas('tutores', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();
    }

    public function create(array $params)
    {
        $conn = \DB::connection();
        try {
            $conn->beginTransaction();
            $pet = PetsModel::query()->create([
                'nome'            => $params["nome"],
                'especie'         => $params["especie"],
                'raca'            => $params["raca"],
                'cor'             => $params["cor"],
                'data_nascimento' => $params["dataNascimento"],
                'sexo'            => $params["sexo"],
                'personalidade'   => $params["personalidade"],
                'observacoes'     => $params["observacoes"],
                'animal_chipado'  => $params["animalChipado"] ?? false,
                'numero_chip'     => $params["numeroChip"] ?? null,
                'foto'            => $params["foto"] ?? null,
            ]);
            if (!empty($params['foto'])) {
                $file = $params['foto'];

                $uploadResult = $this->cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder'        => 'pets/' . $pet->id . '/perfil',
                        'public_id'     => (string)Str::uuid(),
                        'resource_type' => 'image',
                    ]
                );

                $pet->update([
                    'foto'    => $uploadResult['secure_url'],
                    'id_foto' => $uploadResult['public_id'],
                ]);
            }

            if (!empty($params['peso'])) {
                HistoricoPesoModel::query()->create([
                    'pet_id'        => $pet->id,
                    'peso'          => $params['peso'],
                    'data_registro' => now(),
                ]);
            }

            $pet->tutores()->attach(auth()->id());

            $conn->commit();

            return $pet;

        } catch (\Throwable $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function update(array $params)
    {
        $conn = \DB::connection();
        try {
            $conn->beginTransaction();
            $pet = PetsModel::query()
                            ->whereHas('tutores', function ($query) {
                                $query->where('user_id', auth()->id());
                            })
                            ->findOrFail($params['id']);
            $pet->update([
                'nome'            => $params["nome"],
                'especie'         => $params["especie"],
                'raca'            => $params["raca"],
                'cor'             => $params["cor"],
                'data_nascimento' => $params["dataNascimento"],
                'sexo'            => $params["sexo"],
                'personalidade'   => $params["personalidade"],
                'observacoes'     => $params["observacoes"],
                'animal_chipado'  => $params["animalChipado"] ?? false,
                'numero_chip'     => $params["numeroChip"] ?? null,
            ]);

            $pesoAtual = $pet->peso()->orderBy('id', 'desc')->first()?->peso;

            if (($params['peso'] ?? null) != null && $pesoAtual != $params["peso"]) {
                HistoricoPesoModel::query()->create([
                    'pet_id'        => $pet->id,
                    'peso'          => $params['peso'],
                    'data_registro' => now(),
                ]);
            }
            $conn->commit();

            return $pet;
        } catch (\Throwable $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function alterarFoto(array $params)
    {
        $conn = \DB::connection();
        try {
            $conn->beginTransaction();
            $pet = PetsModel::query()
                            ->whereHas('tutores', function ($query) {
                                $query->where('user_id', auth()->id());
                            })
                            ->findOrFail($params['id']);
            if (!empty($params['foto'])) {
                if (!empty($pet->foto)) {


                    // Exclua a imagem antiga do Cloudinary
                    $this->cloudinary->uploadApi()->destroy($pet->id_foto, ['resource_type' => 'image']);
                }
                $file = $params['foto'];


                $uploadResult = $this->cloudinary->uploadApi()->upload(
                    $file->getRealPath(),
                    [
                        'folder'        => 'pets/' . $pet->id . '/perfil',
                        'public_id'     => (string)Str::uuid(),
                        'resource_type' => 'image',
                    ]
                );

                $pet->update([
                    'foto' => $uploadResult['secure_url'],
                    'id_foto' => $uploadResult['public_id'],
                ]);
            }
            $conn->commit();

            return $pet;
        } catch (\Throwable $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function removerFoto(array $params)
    {
        $pet = PetsModel::query()
                        ->whereHas('tutores', function ($query) {
                            $query->where('user_id', auth()->id());
                        })
                        ->findOrFail($params['id']);
        if (!empty($pet->foto)) {

            $this->cloudinary->uploadApi()->destroy($pet->id_foto, ['resource_type' => 'image']);
        }
        $pet->update([
            'foto' => null,
            'id_foto' => null,
        ]);

        return $pet;

    }
}
