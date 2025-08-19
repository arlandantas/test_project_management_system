<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();

        foreach ($users as $user) {
            \App\Models\Project::factory()
                ->count(5)
                ->for($user, 'creator')
                ->create();

            \App\Models\Project::factory()
                ->count(rand(0, 3))
                ->inactive()
                ->for($user, 'creator')
                ->create();
        }
    }
}
