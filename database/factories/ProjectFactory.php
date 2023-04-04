<?php

namespace Database\Factories;

use App\Models\Countries;
use App\Models\User;
use App\Models\UsersProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'author_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
