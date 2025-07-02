<?php

namespace App\Jobs;

use Cache;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteCompletedTask implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected $taskId;

    /**
     * Crie uma nova instância
     */
    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * Executa o job
     */
    public function handle(): void
    {
        $task = Task::withTrashed()->find($this->taskId);

        if ($task && $task->trashed() && $task->completed) {
            $task->forceDelete();
        }
    }

    /**
     * Dispara o job com delay após marcar tarefa como finalizada (no método toggle do controller)
     */
    public function toggle(Task $task)
    {
        $task->update(['completed' => !$task->completed]);

        Cache::tags('tasks')->flush();

        if ($task->completed) {
            // Dispatch job para deletar permanentemente em 10 minutos
            DeleteCompletedTask::dispatch($task->id)->delay(now()->addMinutes(10));
        }

        return response()->json($task);
    }
}
