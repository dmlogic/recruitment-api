<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Dmlogic\RecruitmentApi\Models\Position;
use Dmlogic\RecruitmentApi\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'token' => Str::random(),
            'email' => $this->faker->safeEmail,
        ];
    }
}
