<?php

namespace App\Console\Commands;

use App\Services\TaskAutomationService;
use Illuminate\Console\Command;

class RunTaskAutomation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:automation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run task automation workflows';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running task automation workflows...');
        
        $automationService = new TaskAutomationService();
        $automationService->runAutomations();
        
        $stats = $automationService->getAutomationStats();
        
        $this->info('Automation completed successfully!');
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Tasks', $stats['total_tasks']],
                ['Completed Tasks', $stats['completed_tasks']],
                ['In Progress Tasks', $stats['in_progress_tasks']],
                ['Pending Tasks', $stats['pending_tasks']],
                ['High Priority Tasks', $stats['high_priority_tasks']],
                ['Old In Progress Tasks', $stats['old_in_progress_tasks']],
                ['Completion Rate', $stats['completion_rate'] . '%'],
            ]
        );
    }
}
