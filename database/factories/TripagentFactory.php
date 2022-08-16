<?php

namespace Database\Factories;

use App\Models\Tripagent;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripagentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tripagent::class;

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
        'type' => $this->faker->randomElement(['Tourism_Company','educational_service']),
        'verified_at'=>now(),
    ];
    }
}
