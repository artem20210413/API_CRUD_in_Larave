<?php

namespace Database\Factories;

use App\Models\Label;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectsLabel>
 */
class ProjectsLabelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $randomProject = Project::inRandomOrder()->first();
            $randomLabel= Label::inRandomOrder()->first();
        } while ($randomProject->labels->contains($randomLabel));

        return [
            'project_id' => $randomProject->id,
            'label_id' => $randomLabel->id,
        ];
    }
}
