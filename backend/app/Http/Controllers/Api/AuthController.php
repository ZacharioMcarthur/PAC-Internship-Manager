<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'nullable|in:stagiaire,maitre,admin',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'password' => Hash::make((string) $request->input('password')),
            'role' => $request->input('role', 'stagiaire'),
        ]);

        $token = $user->createToken('pac_mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Compte créé avec succès',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->input('email'))->first();
        if (!$user || !Hash::check((string) $request->input('password'), $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants invalides',
            ], 401);
        }

        $token = $user->createToken('pac_mobile')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $request->user(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie',
        ]);
    }
}
