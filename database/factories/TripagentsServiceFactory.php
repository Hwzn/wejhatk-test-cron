<?php

namespace Database\Factories;

use App\Models\TripagentsService;
use App\Models\Tripagent;
use App\Models\Serivce;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripagentsServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TripagentsService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => Serivce::all()->random()->id,
            'tripagent_id' => Tripagent::all()->random()->id,
        ];
    }
}
