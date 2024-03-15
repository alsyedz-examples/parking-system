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
        'label', 'price'
    ];

    /**
     * The attributes that are type casted.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2'
    ];

    /**
     * The attributes that append to the model.
     *
     * @var array<string>
     */
    protected $appends = ['booked_slots'];

    /**
     * get available slots.
     */
    protected function getBookedSlotsAttribute()
    {
        return $this->bookings()->get();
    }

    /**
     * Get the bookings for this parking spot.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
