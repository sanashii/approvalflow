<?php

/**
 * GOTeam Demo App - Automation Demo Script
 * 
 * This script demonstrates the automation features by creating tasks
 * with different ages and priorities to trigger various automation rules.
 */

require_once 'vendor/autoload.php';

use App\Models\Task;
use App\Models\User;
use App\Services\TaskAutomationService;
use Carbon\Carbon;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🚀 GOTeam Demo App - Automation Demo\n";
echo "=====================================\n\n";

// Get or create demo user
$user = User::firstOrCreate(
    ['email' => 'demo@example.com'],
    [
        'name' => 'Demo User',
        'password' => bcrypt('password'),
    ]
);

echo "👤 Demo User: {$user->name} ({$user->email})\n\n";

// Clear existing tasks for clean demo
Task::where('user_id', $user->id)->delete();

echo "🧹 Cleared existing tasks for clean demo\n\n";

// Create demo tasks with different scenarios
$demoTasks = [
    [
        'title' => 'Old In Progress Task (8 days old)',
        'description' => 'This task should be auto-completed by automation',
        'priority' => 'Normal',
        'status' => 'In Progress',
        'created_at' => Carbon::now()->subDays(8),
        'updated_at' => Carbon::now()->subDays(8),
    ],
    [
        'title' => 'Overdue High Priority Task (5 days old)',
        'description' => 'This high priority task should trigger escalation',
        'priority' => 'High',
        'status' => 'Pending',
        'created_at' => Carbon::now()->subDays(5),
        'updated_at' => Carbon::now()->subDays(5),
    ],
    [
        'title' => 'Recent High Priority Task (1 day old)',
        'description' => 'This is a recent high priority task',
        'priority' => 'High',
        'status' => 'In Progress',
        'created_at' => Carbon::now()->subDay(),
        'updated_at' => Carbon::now()->subDay(),
    ],
    [
        'title' => 'Normal Task (2 days old)',
        'description' => 'This is a normal priority task',
        'priority' => 'Normal',
        'status' => 'Pending',
        'created_at' => Carbon::now()->subDays(2),
        'updated_at' => Carbon::now()->subDays(2),
    ],
    [
        'title' => 'Completed Task',
        'description' => 'This task is already completed',
        'priority' => 'Low',
        'status' => 'Completed',
        'created_at' => Carbon::now()->subDays(3),
        'updated_at' => Carbon::now()->subDays(1),
    ],
];

echo "📝 Creating demo tasks...\n";
foreach ($demoTasks as $taskData) {
    $task = Task::create(array_merge($taskData, ['user_id' => $user->id]));
    echo "   ✓ Created: {$task->title} ({$task->status})\n";
}

echo "\n📊 Initial Task Statistics:\n";
$automationService = new TaskAutomationService();
$stats = $automationService->getAutomationStats();

echo "   Total Tasks: {$stats['total_tasks']}\n";
echo "   Completed: {$stats['completed_tasks']}\n";
echo "   In Progress: {$stats['in_progress_tasks']}\n";
echo "   Pending: {$stats['pending_tasks']}\n";
echo "   High Priority: {$stats['high_priority_tasks']}\n";
echo "   Old In Progress: {$stats['old_in_progress_tasks']}\n";
echo "   Completion Rate: {$stats['completion_rate']}%\n\n";

echo "🤖 Running Automation Workflows...\n";
echo "==================================\n";

$automationService->runAutomations();

echo "\n📊 Post-Automation Statistics:\n";
$stats = $automationService->getAutomationStats();

echo "   Total Tasks: {$stats['total_tasks']}\n";
echo "   Completed: {$stats['completed_tasks']}\n";
echo "   In Progress: {$stats['in_progress_tasks']}\n";
echo "   Pending: {$stats['pending_tasks']}\n";
echo "   High Priority: {$stats['high_priority_tasks']}\n";
echo "   Old In Progress: {$stats['old_in_progress_tasks']}\n";
echo "   Completion Rate: {$stats['completion_rate']}%\n\n";

echo "✅ Demo completed! Check the application at http://localhost:8000\n";
echo "   Login with: demo@example.com / password\n\n";

echo "🎯 What happened:\n";
echo "   • Old 'In Progress' task was auto-completed\n";
echo "   • Overdue high priority task was flagged for escalation\n";
echo "   • Statistics were updated to reflect changes\n";
echo "   • All automation rules were applied\n\n";

echo "🔗 Next steps:\n";
echo "   1. Visit http://localhost:8000\n";
echo "   2. Login with demo@example.com / password\n";
echo "   3. Explore the Dashboard and Tasks pages\n";
echo "   4. Try creating, editing, and updating tasks\n";
echo "   5. Run automation manually from the Tasks page\n\n";
