<?php

namespace App\Http\Library;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

trait ApiHelpers
{
    protected function isAdmin($user): bool
    {
        if($user == 1){
            return true;
        }

        return false;
    }

    protected function isUser($user): bool
    {
        if($user == 2){
            return true;
        }

        return false;
    }

    protected function isValidator($user): bool
    {
        if($user == 3){
            return true;
        }

        return false;
    }

    protected function onSuccess($data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function onError(int $code, string $message = ''): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }

    

    protected function userValidatedRules($id = ""): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required']
        ];
    }

    protected function dataValidatedRules(): array
    {
        return [
            'standar' => ['required', 'string'],
            'judul' => ['required', 'string'],
            'kategori' => ['required', 'string'],
            'tahun' => ['required', 'string'],
            'status' => ['required'],
            'deskripsi' => ['required', 'string', 'max:255'],
             
        ];
    }
    
    protected function documentValidatedRules(): array
    {
        return [
            'document' => ['required', 'mimes:pdf,word', 'max:10240']
        ];
    }
    
}
