<?php

namespace Database\Factories;

use App\Models\ParkingSpot;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParkingSpotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ParkingSpot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'label' => $this->faker->word
        ];
    }
}
