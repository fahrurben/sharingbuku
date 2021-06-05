<?php

namespace Database\Factories;

use App\Models\Lookup;
use Illuminate\Database\Eloquent\Factories\Factory;

class LookupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lookup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => 1,
            'key' => $this->faker->slug(),
            'value' => $this->faker->text(),
        ];
    }
}
