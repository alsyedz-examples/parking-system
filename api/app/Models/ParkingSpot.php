<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSpot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'label'
    ];

    /**
     * Get the bookings for this parking spot.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
