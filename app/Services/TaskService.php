<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Cache;

class TaskService
{
    public function getAll()
    {
        return Cache::tags('tasks')->remember('tasks.all', 60, function () {
            return Task::latest()->get();
        });
    }

    public function getById(Task $task)
    {
        $cacheKey = "tasks.{$task->id}";

        return Cache::tags('tasks')->remember($cacheKey, 60, function () use ($task) {
            return $task;
        });
    }

    public function create(array $data): Task
    {
        $task = Task::create($data);

        Cache::tags('tasks')->flush();

        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        Cache::tags('tasks')->flush();

        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();

        Cache::tags('tasks')->flush();
    }

    public function toggle(Task $task): Task
    {
        $task->update(['completed' => !$task->completed]);

        Cache::tags('tasks')->flush();

        return $task;
    }
}
