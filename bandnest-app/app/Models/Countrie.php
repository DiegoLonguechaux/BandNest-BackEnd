<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// #[ApiResource(
//     operations: [
//         new Get(),
//         new Post(),
//         new GetCollection(),
//         new Patch(),
//     ]
// )]
class Countrie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the users associated with the country.
     */
    public function structures()
    {
        return $this->hasMany(Structure::class);
    }

    /**
     * Get the users associated with the country.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
