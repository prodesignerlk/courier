<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WaybillType;

class WaybillTypeFactory extends Factory
{
     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    
    protected $model = \App\Models\WaybillType::class;
    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => $this->faker->name(),
            'description' => $this->faker->name(),
            'org_id' => '1',
        ];
    }
}
