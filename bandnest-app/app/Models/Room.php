<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ApiResource]
class Room extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'structure_id',
        'name',
        'size',
        'description',
        'price_per_hour',
        'address',
        'city',
        'zip_code',
        'country_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'size' => 'decimal:2',
        'price_per_hour' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the structure associated with the room.
     */
    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    /**
     * Get the bookings associated with the room.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the photos associated with the room.
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * Get the operating hours associated with the room.
     */
    public function operatingHours()
    {
        return $this->hasMany(OperatingHour::class);
    }

    /**
     * Get the materials associated with the room.
     */
    public function materials()
    {
        return $this->belongsToMany(Material::class, 'room_materials');
    }

    /**
     * Get the country associated with the structure.
     */
    public function country()
    {
        return $this->belongsTo(Countrie::class, 'country_id');
    }
}
