<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskAutomationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tasks = $user ? $user->tasks()->orderBy('created_at', 'desc')->get() : collect();
        
        return Inertia::render('Tasks', [
            'tasks' => $tasks
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Normal,High',
            'status' => 'required|in:Pending,In Progress,Completed'
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $task = $user->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Task created successfully!');
    }

    public function update(Request $request, Task $task)
    {
        // Ensure user can only update their own tasks
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Low,Normal,High',
            'status' => 'required|in:Pending,In Progress,Completed'
        ]);

        $task->update($request->only(['title', 'description', 'priority', 'status']));

        return redirect()->back()->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        // Ensure user can only delete their own tasks
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Ensure user can only update their own tasks
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed'
        ]);

        $task->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Task status updated successfully!');
    }

    public function runAutomation()
    {
        $automationService = new TaskAutomationService();
        $automationService->runAutomations();
        
        $stats = $automationService->getAutomationStats();
        
        return redirect()->back()->with('success', 'Automation workflows completed successfully!');
    }
}
