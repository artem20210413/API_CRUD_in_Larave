<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UsersProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $randomUser = User::inRandomOrder()->first();
            $randomProject = Project::inRandomOrder()->first();
        } while ($randomUser->projects->contains($randomProject));

        return [
            'user_id' => $randomUser->id,
            'project_id' => $randomProject->id,
        ];
    }
}
