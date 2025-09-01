<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // usa el User por defecto

class AuthController extends Controller
{
    public function issueToken(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
            'abilities'=> ['array'], // opcional
        ]);

        $user = User::where('email', $validated['email'])->first();
        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $abilities = $validated['abilities'] ?? ['ikiambio.read'];
        $token = $user->createToken('external-system', $abilities)->plainTextToken;

        return response()->json(['token' => $token], 201);
    }
}
