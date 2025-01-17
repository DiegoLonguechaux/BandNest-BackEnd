<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Http\Controllers\ProfileController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

// #[ApiResource(
//     operations: [
//         new Get(),
//         new Post(
//             inputFormats: ['multipart' => ['multipart/form-data']],
//         ),
//         new GetCollection(),
//         new Patch(),
//         new Patch(            
//             controller: ProfileController::class,  // Le contrôleur à utiliser
//             uriTemplate: '/users/{id}',  // La route à utiliser
//             inputFormats: ['multipart' => ['multipart/form-data']],
//             outputFormats: ['json' => ['application/json']],
//             deserialize: false,  // Désérialisation manuelle
//             name: 'update',  // Nom de l'opération (optionnel)
//         ),
//     ]
// )]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'date_of_birth',
        'email',
        'password',
        'profile_photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the bands associated with the users.
     */
    public function bands()
    {
        return $this->belongsToMany(Band::class, 'user_bands');
    }

    /**
     * Get the structures associated with the users.
     */
    public function structures()
    {
        return $this->hasMany(Structure::class, 'owner_id');
    }

    /**
     * Get the bookings associated with the users.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
