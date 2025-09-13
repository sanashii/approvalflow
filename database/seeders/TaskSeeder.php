<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test user if none exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Create sample tasks with different ages to demonstrate automation
        $tasks = [
            // Very old tasks (15+ days) - should be auto-completed
            [
                'title' => 'Complete project documentation',
                'description' => 'Write comprehensive documentation for the GOTeam Demo App including setup instructions and feature overview.',
                'priority' => 'High',
                'status' => 'In Progress',
                'created_at' => Carbon::now()->subDays(15),
                'updated_at' => Carbon::now()->subDays(15),
            ],
            [
                'title' => 'Implement user authentication',
                'description' => 'Set up Laravel Breeze authentication system with login, register, and logout functionality.',
                'priority' => 'High',
                'status' => 'In Progress',
                'created_at' => Carbon::now()->subDays(12),
                'updated_at' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'Create task management system',
                'description' => 'Build CRUD operations for tasks with Vue.js frontend and Laravel backend.',
                'priority' => 'Normal',
                'status' => 'In Progress',
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now()->subDays(10),
            ],
            
            // Overdue high priority tasks (5+ days pending) - should trigger escalation
            [
                'title' => 'Fix critical security vulnerability',
                'description' => 'Address security issues found in the authentication system.',
                'priority' => 'High',
                'status' => 'Pending',
                'created_at' => Carbon::now()->subDays(8),
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'title' => 'Database optimization',
                'description' => 'Optimize database queries for better performance.',
                'priority' => 'High',
                'status' => 'Pending',
                'created_at' => Carbon::now()->subDays(6),
                'updated_at' => Carbon::now()->subDays(6),
            ],
            
            // Recent tasks (1-3 days) - should remain unchanged
            [
                'title' => 'Add automation workflows',
                'description' => 'Implement automated task status updates and workflow triggers.',
                'priority' => 'Normal',
                'status' => 'In Progress',
                'created_at' => Carbon::now()->subDays(2),
                'updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Design responsive UI',
                'description' => 'Create mobile-friendly interface using Tailwind CSS.',
                'priority' => 'Low',
                'status' => 'Pending',
                'created_at' => Carbon::now()->subDay(),
                'updated_at' => Carbon::now()->subDay(),
            ],
            [
                'title' => 'Write unit tests',
                'description' => 'Add comprehensive test coverage for all features.',
                'priority' => 'Normal',
                'status' => 'Pending',
                'created_at' => Carbon::now()->subHours(12),
                'updated_at' => Carbon::now()->subHours(12),
            ],
            
            // Some completed tasks
            [
                'title' => 'Setup development environment',
                'description' => 'Configure local development environment with all necessary tools.',
                'priority' => 'High',
                'status' => 'Completed',
                'created_at' => Carbon::now()->subDays(20),
                'updated_at' => Carbon::now()->subDays(18),
            ],
            [
                'title' => 'Deploy to production',
                'description' => 'Set up production environment and deploy the application.',
                'priority' => 'High',
                'status' => 'Completed',
                'created_at' => Carbon::now()->subDays(14),
                'updated_at' => Carbon::now()->subDays(12),
            ],
        ];

        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, ['user_id' => $user->id]));
        }
    }
}
