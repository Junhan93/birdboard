<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use WithFaker; // I can gain access to quick access to random data
    use RefreshDatabase; // writing a test that will change your database, use this trait -> database refreshes back to initial stage
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_user_can_create_a_project()
    {
        // disable exception handling
        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),

        ];

        // if we submit a post request
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        // i expect it to insert into the database 'projects' table

        // assertRedirect() requires a return redirect in Controller before the testing below
        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_a_project()
    {
        // disable exception handling so we can see what is going on
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        // get projects by id and test title and description
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $attributes = Project::factory()->raw(['title' => '']);

        // if i make a post request to that endpoint but I dont give it a title, im going to assert that the session has errors
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $attributes = Project::factory()->raw(['description' => '']);

        // if i make a post request to that endpoint but I dont give it a description, im going to assert that the session has errors
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
