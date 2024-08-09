<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tests\Traits\CreatesApplication;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware, CreatesApplication;


    public function testStoreMethod()
    {
        $taskData = [
            'name' => 'Study for test',
            'description' => 'Start studying for mathematics test',
        ];

        $response = $this->json('POST', '/api/todos', $taskData);

        // Ensure that the HTTP status code is 201
        $response->assertStatus(201);

        // Check returned data
        $response->assertJsonPath('name', $taskData['name']);

        // Verify that the task is successfully stored in the database
        $this->assertDatabaseHas('tasks', $taskData);
    }
}
