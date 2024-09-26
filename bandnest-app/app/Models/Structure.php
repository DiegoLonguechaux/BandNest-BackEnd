<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ApiPlatform\Metadata\ApiResource;

#[ApiResource]
class Structure extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'zip_code',
        'country_id',
        'owner_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the owner associated with the structure.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the country associated with the structure.
     */
    public function country()
    {
        return $this->belongsTo(Countrie::class, 'country_id');
    }

    /**
     * Get the rooms associated with the structure.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the photos associated with the structure.
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
