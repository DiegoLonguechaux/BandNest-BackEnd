<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation des champs de connexion
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Vérifier les informations d'identification utilisateur
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Créer un token pour l'utilisateur
        $token = $user->createToken('MyAppToken')->plainTextToken;

        // Retourner le token en réponse JSON
        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        // Révoquer le token de l'utilisateur
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }
}
