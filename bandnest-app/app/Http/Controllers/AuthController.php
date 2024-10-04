<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retourner le token en réponse JSON
        return response()->json([
            'message' => 'Login successful',
            // 'token' => $token,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        // Révoquer le token de l'utilisateur
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function register(Request $request)
    {
        // Validation des données d'inscription
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:musician,owner,superadmin',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Créer un nouvel utilisateur
        $user = User::create([
            'name' => $request->name,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assigner le rôle à l'utilisateur (musician ou owner)
        $user->assignRole($request->role);

        // Envoyer un email de vérification
        $user->sendEmailVerificationNotification();

        // Connecter l'utilisateur
        Auth::login($user);

        // Créer un token Sanctum pour l'utilisateur
        $token = $user->createToken('MyAppToken')->plainTextToken;

        // Retourner la réponse avec le token
        return response()->json([
            'message' => 'User registered successfully. Please check your email to verify your account.',
            'user' => $user,
            // 'token' => $token,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ], 201);
    }

}
