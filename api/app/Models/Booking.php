<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'start_date', 'end_date', 'parking_spot_id'
    ];

    /**
     * The attributes that are type casted.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2'
    ];

    /**
     * Get the parking slot that owns this booking.
     */
    public function parking_slot()
    {
        return $this->belongsTo(ParkingSpot::class);
    }
}
