<?php

use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CountrieController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OperatingHourController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StructureController;
use App\Models\Structure;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::middleware(['auth:sanctum', 'verified', 'role:super_admin'])->group(function () {
    Route::get('/api', function () {
        return response()->json([
            'message' => 'Welcome, Super Admin!',
        ]);
    });
});

Route::middleware('auth:sanctum', 'verified')->group(function () {
    // Route::resources('/users', [ProfileController::class, 'store']);
    // Route::post('/users/{id}', [ProfileController::class, 'update']);
    Route::get('/check-auth', [AuthController::class, 'checkAuth'])->name('check-auth');
    Route::get('/users/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/users/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/users/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::apiResource('bands', BandController::class);
    Route::apiResource('bookings', BookingController::class);
    Route::apiResource('countries', CountrieController::class);
    Route::apiResource('genres', GenreController::class);
    Route::apiResource('materials', MaterialController::class);
    Route::apiResource('operating-hours', OperatingHourController::class);
    Route::apiResource('photos', PhotoController::class);
    // Route::apiResource('rooms', RoomController::class);
    Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::patch('rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');
    Route::apiResource('structures', StructureController::class);
});

// Envoyer un email de vérification après l'inscription
Route::middleware('auth:sanctum')->get('/email/verify', function (Request $request) {
    return $request->user()->sendEmailVerificationNotification();
});

// Envoyer un email de vérification après l'inscription
Route::middleware(['auth:sanctum'])->post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('verification.send');

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
