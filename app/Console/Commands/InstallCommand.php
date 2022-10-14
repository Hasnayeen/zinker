<?php

namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zinker:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Zinker\' necessary component';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Project $project)
    {
        $project->path = base_path();
        $project->database = config('database.connections.' . config('database.default') . '.database');
        $project->default = true;
        
        $this->info('Zinker is installed successfully.');

        return Command::SUCCESS;
    }
}
