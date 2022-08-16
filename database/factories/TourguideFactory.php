<?php

namespace Database\Factories;

use App\Models\Tourguide;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourguideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tourguide::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'starnumber' => $this->faker->randomElement([1,2,3,4,5]),
            ];
    }
}
