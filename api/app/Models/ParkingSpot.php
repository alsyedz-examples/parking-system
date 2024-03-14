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
}
