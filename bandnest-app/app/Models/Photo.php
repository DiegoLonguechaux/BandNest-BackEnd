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
class Photo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'url',
        'room_id',
        'structure_id',
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
     * Get the room associated with the photo.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the structure associated with the photo.
     */
    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }
}
