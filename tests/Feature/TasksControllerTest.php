<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\Traits\CreatesApplication;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware, CreatesApplication;


    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/api/');

        $response->assertStatus(200);
    }


    public function testStoreMethod()
    {
        $taskData = [
            'title' => 'Study for test',
            'description' => 'Start studying for mathematics test',
            'status' => 'In progress',
            'due_date' => '2022-12-31',
        ];

        $response = $this->json('POST', '/api/tasks', $taskData);

        // Ensure that the HTTP status code is 201
        $response->assertStatus(201);

        // Check returned data
        $response->assertJsonFragment(['message' => 'Task created successfully']);
        $response->assertJsonPath('data.title', $taskData['title']);

        // Verify that the task is successfully stored in the database
        $this->assertDatabaseHas('tasks', $taskData);
    }
}
