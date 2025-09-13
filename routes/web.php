<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Task;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    if (!$user) {
        abort(403, 'Unauthorized');
    }

    $taskStats = [
        'total' => $user->tasks()->count(),
        'pending' => $user->tasks()->where('status', 'Pending')->count(),
        'in_progress' => $user->tasks()->where('status', 'In Progress')->count(),
        'completed' => $user->tasks()->where('status', 'Completed')->count(),
    ];
    
    $recentTasks = $user->tasks()->orderBy('created_at', 'desc')->limit(5)->get();
    
    return Inertia::render('Dashboard', [
        'taskStats' => $taskStats,
        'recentTasks' => $recentTasks
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
    Route::post('/tasks/automation', [TaskController::class, 'runAutomation'])->name('tasks.automation');
});

require __DIR__.'/auth.php';
