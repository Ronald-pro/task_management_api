<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function create_task()
    {
        $result = [
            'title' => 'New trends',
            'description' => 'The article states the new trends in areas of interest!',
            'priority' => 'medium',
            'due_date' => '2025-04-30',
        ];
        $response = $this->postJson('/api/create/task', $result);
        $response->assertStatus(201)
         ->assertJson([
            'success' => true,
            'message' => 'successfully created the task',
         ]);

         $this->assertDatabaseHas('task', [
            'title' => 'New trends'
         ]);
    }

    public function validate_title()
    {
        $response = $this->postJson('/api/create/task', []);
        $response->assertStatus(422)
        ->assertJsonValidationErrors(['title']);
    }

    public function get_a_task()
    {
        $task = Task::factory()->create();
        $response = $this->getJson("/api/task/{$task->id}");
        $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'id' => $task->id,
                'title' => $task->title
            ]
            ]);
    }
}
