<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = \App\Models\Project::all();

        foreach ($projects as $project) {
            \App\Models\Task::factory()
                ->count(rand(1, 5))
                ->for($project)
                ->for($project->creator, 'creator')
                ->create();
        }
    }
}
