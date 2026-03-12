<?php

namespace App\Http\Controllers;

use App\Actions\Api\CreateNewUser;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;

class AuthController
{
    public function register(Request $request)
    {
        try {
            $data     = AuthRequest::create($request->all())->validated();
            $response = CreateNewUser::create($data);

            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'user'    => $response
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar usuário',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
