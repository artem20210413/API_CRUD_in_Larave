<?php

namespace Database\Seeders;

use App\Models\ProjectsLabel;
use Illuminate\Database\Seeder;

class LabelProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectsLabel::factory(10)->create();
    }
}
