<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }

    public function testGuestRedirectsToLogin()
    {
        $response = $this->get('/projects');
        $response->assertRedirect('/login');
    }

    public function testAuthenticatedUsersCanVisitTheProjectsPage()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/projects');
        $response->assertStatus(200);
    }

    public function testProjectCreationRequiresValidData()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson(route('projects.store'), [
            'name' => '', // Invalid project name
            'status' => 'Active',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'value' => 1000,
        ]);


        $response->assertClientError();
    }
}
