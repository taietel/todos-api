<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Tasks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TasksController extends Controller
{
    public function index(): JsonResponse
    {
         $tasks = Tasks::query()->get();

         return response()->json(
            $tasks
         );
    }

    public function store(CreateTaskRequest $request): JsonResponse
    {
        $params = $request->validated();
        $task = Tasks::create($params);

        return response()->json(
            new TaskResource($task)
        , 201);
    }

    public function delete(int $id): JsonResponse
    {
        $task = Tasks::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Task not found',
            ], 404);
        }
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ], 203);
    }
}
