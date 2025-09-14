<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\TaskAutomationService;
use App\Models\User;
use App\Models\Task;

class TaskAutomationServiceTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function service_runs_without_throwing()
    {
        $service = app(TaskAutomationService::class);

        // Call the public entry point used in the app
        $this->assertTrue(method_exists($service, 'runAutomations'));

        try {
            $service->runAutomations();
        } catch (\Throwable $e) {
            $this->fail('TaskAutomationService::runAutomations threw an exception: ' . $e->getMessage());
            return;
        }

        $this->assertTrue(true);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_autocompletes_old_in_progress_tasks()
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create([
            'status' => 'In Progress',
            'priority' => 'Normal',
            'updated_at' => now()->subDays(10),
            'created_at' => now()->subDays(30),
        ]);

        $service = app(TaskAutomationService::class);
        $this->assertTrue(method_exists($service, 'runAutomations'));

        $service->runAutomations();

        $task->refresh();

        $this->assertEquals('Completed', $task->status, 'Old in-progress task should be auto-completed');
    }
}