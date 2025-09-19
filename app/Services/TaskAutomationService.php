<?php

namespace App\Services;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TaskAutomationService
{
    /**
     * Run automation workflows for tasks
     */
    public function runAutomations(): void
    {
        $this->autoCompleteOldTasks();
        $this->escalateOverdueTasks();
        $this->notifyHighPriorityTasks();
    }

    /**
     * Automatically complete tasks that have been in "In Progress" status for more than 7 days
     */
    private function autoCompleteOldTasks(): void
    {
        $cutoffDate = Carbon::now()->subDays(7);
        
        $tasks = Task::where('status', 'In Progress')
            ->where('updated_at', '<', $cutoffDate)
            ->get();

        foreach ($tasks as $task) {
            $task->update(['status' => 'Completed']);
            Log::info("Auto-completed task: {$task->title} (ID: {$task->id})");
        }

        if ($tasks->count() > 0) {
            Log::info("Auto-completed {$tasks->count()} tasks that were in progress for more than 7 days");
        }
    }

    /**
     * Escalate high priority tasks that have been pending for more than 3 days
     */
    private function escalateOverdueTasks(): void
    {
        $cutoffDate = Carbon::now()->subDays(3);
        
        // First, clear all existing overdue flags
        Task::where('is_overdue', true)->update(['is_overdue' => false]);
        
        // Then flag overdue high priority tasks
        $tasks = Task::where('status', 'Pending')
            ->where('priority', 'High')
            ->where('created_at', '<', $cutoffDate)
            ->get();

        foreach ($tasks as $task) {
            $task->update(['is_overdue' => true]);
            Log::warning("High priority task overdue: {$task->title} (ID: {$task->id}) - Created: {$task->created_at}");
        }

        if ($tasks->count() > 0) {
            Log::warning("Found {$tasks->count()} overdue high priority tasks");
        }
    }

    /**
     * Log high priority tasks for monitoring
     */
    private function notifyHighPriorityTasks(): void
    {
        $highPriorityTasks = Task::where('priority', 'High')
            ->where('status', '!=', 'Completed')
            ->count();

        if ($highPriorityTasks > 0) {
            Log::info("Currently {$highPriorityTasks} high priority tasks in progress");
        }
    }

    /**
     * Get automation statistics
     */
    public function getAutomationStats(): array
    {
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'Completed')->count();
        $inProgressTasks = Task::where('status', 'In Progress')->count();
        $pendingTasks = Task::where('status', 'Pending')->count();
        $highPriorityTasks = Task::where('priority', 'High')->where('status', '!=', 'Completed')->count();
        
        $oldInProgressTasks = Task::where('status', 'In Progress')
            ->where('updated_at', '<', Carbon::now()->subDays(7))
            ->count();

        return [
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'in_progress_tasks' => $inProgressTasks,
            'pending_tasks' => $pendingTasks,
            'high_priority_tasks' => $highPriorityTasks,
            'old_in_progress_tasks' => $oldInProgressTasks,
            'completion_rate' => $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 2) : 0,
        ];
    }
}
