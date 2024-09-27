<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum', 'verified')->group(function () {
    Route::get('/rooms', function () {
        return response()->json(['message' => 'Let\'s see the rooms']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Envoyer un email de vérification après l'inscription
Route::middleware('auth:sanctum')->get('/email/verify', function (Request $request) {
    return $request->user()->sendEmailVerificationNotification();
});

// Route pour vérifier l'email via le lien reçu
Route::middleware(['auth:sanctum', 'signed'])->get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully.']);
})
->name('verification.verify')
;

// Renvoyer l'email de vérification si l'utilisateur n'a pas encore vérifié son adresse
Route::middleware(['auth:sanctum', 'throttle:6,1'])->post('/email/resend', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified.'], 400);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => 'Verification email sent.']);
});
