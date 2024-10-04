<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum', 'verified')->group(function () {
//     Route::get('/rooms', function () {
//         return response()->json(['message' => 'Let\'s see the rooms']);
//     });
// });

// Route::middleware('auth:sanctum', 'verified')->group(function () {
//     Route::post('/rooms', function (Request $request) {
//         $user = $request->user();
//         // Vérifier si l'utilisateur a les rôles super_admin ou owner
//         if ($user->hasAnyRole(['super_admin', 'owner'])) {
//             return response()->json(['message' => 'Room created successfully']);
//         } else {
//             return response()->json(['message' => 'Access denied. You do not have permission to create rooms.'], 403);
//         }

//         // Si l'utilisateur n'a ni le rôle ni la permission
//         // return response()->json(['message' => 'Room created successfuly']);
//     })->middleware('auth:sanctum');
// });

Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
});

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Envoyer un email de vérification après l'inscription
Route::middleware('auth:sanctum')->get('/email/verify', function (Request $request) {
    return $request->user()->sendEmailVerificationNotification();
});

// Route pour vérifier l'email via le lien reçu
Route::middleware(['auth:sanctum', 'signed'])->get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return response()->json(['message' => 'Email verified successfully.']);
})
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Renvoyer l'email de vérification si l'utilisateur n'a pas encore vérifié son adresse
Route::middleware(['auth:sanctum', 'throttle:6,1'])->post('/email/resend', function (Request $request) {
    if ($request->user()->hasVerifiedEmail()) {
        return response()->json(['message' => 'Email already verified.'], 400);
    }

    $request->user()->sendEmailVerificationNotification();

    return response()->json(['message' => 'Verification email sent.']);
});
