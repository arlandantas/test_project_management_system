<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnerCanUpdateProject()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create([
            'creator_id' => $user->id,
        ]);

        $this->assertTrue($user->can('update', $project));
    }

    public function testOthersCannotUpdateProject()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $secondUser = User::factory()->create();

        $project = Project::factory()->create([
            'creator_id' => $secondUser->id,
        ]);

        $this->assertFalse($user->can('update', $project));
    }
}
