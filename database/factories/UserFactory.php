<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'adress' => $this->faker->regexify('[A-Za-z0-9]{120}'),
            'zip_code' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'userable_id' => $this->faker->word,
            'userable_type' => $this->faker->regexify('[A-Za-z0-9]{120}'),
            'date_hired' => $this->faker->dateTime(),
            'created_at' => $this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
