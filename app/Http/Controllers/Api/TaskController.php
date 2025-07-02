<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Jobs\DeleteCompletedTask;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->taskService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $task = $this->taskService->create($request->validated());

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return response()->json($this->taskService->getById($task));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Task $task)
    {
        $task = $this->taskService->update($task, $request->validated());

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->taskService->delete($task);

        return response()->json(null, 204);
    }

    public function toggle(Task $task)
    {
        $task = $this->taskService->toggle($task);

        if ($task->completed) {
            DeleteCompletedTask::dispatch($task->id)->delay(now()->addMinutes(10));
        }

        return response()->json($task);
    }
}
