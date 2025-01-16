<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id)
    {
        dd($request);
        $user = User::findOrFail($id);

        // Mise à jour de l'email (si fourni et différent)
        if ($request->has('email') && $request->email !== $user->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;  // Invalider l'email vérifié si l'email change
        }
        
        // Mise à jour du nom (si fourni)
        if ($request->has('firstname')) {
            // dd($request);
            $user->firstname = $request->firstname;
        }
        
        // Gestion de la photo de profil (si un fichier est envoyé)
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');

            // Générer un nom unique pour l'image
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();   
    
            // Stocker l'image dans le dossier 'profile_photos'
            $file->storeAs('profile_photos', $fileName, 'public');
    
            // Supprimer l'ancienne image si elle existe
            if ($user->profile_photo) {
                Storage::disk('public')->delete('profile_photos/' . $user->profile_photo);
            }
    
            // Mettre à jour uniquement le nom du fichier dans la base de données
            $user->profile_photo = $fileName;
            
            
            // // Stocker l'image et générer le chemin
            // $path = $request->file('profile_photo')->store('profile_photos', 'public');
    
            // // Supprimer l'ancienne image si elle existe
            // if ($user->profile_photo) {
            //     Storage::disk('public')->delete($user->profile_photo);
            // }
    
            // // Mettre à jour le chemin de la nouvelle photo dans la base de données
            // $user->profile_photo = $path;
        }
    
        // Sauvegarder les modifications dans la base de données
        $user->save();
    
        // Retourner une réponse JSON avec un message de succès et l'utilisateur mis à jour
        return response()->json([
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
