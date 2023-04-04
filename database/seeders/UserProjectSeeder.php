<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\UsersProject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Project::all() as $project) {
            UsersProject::create([
                'user_id' => $project->author_id,
                'project_id' => $project->id,
            ]);
        }

        UsersProject::factory(10)->create();
    }
}
