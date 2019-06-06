<?php

namespace App\Console\Commands;

use App\Jobs\ProcessLeaves;
use Illuminate\Console\Command;

class LeavesEntitlement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaves:entitlement {employee=<id>}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allocate absence types for employee(s)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // set color support explicitly
        $this->getOutput()->setDecorated(true);

        // Retrieve a specific option...
        $employeeId = $this->argument('employee');

        if(!$employeeId || $employeeId == '<id>'){
            $employeeId = null;
        }
        $this->info("<fg=blue;bg=black> Start\nEmployee supplied</>");
        $this->warn(is_null($employeeId) ? "<fg=red;bg=black>No" : "<fg=green;bg=black>Yes" ."\n</>");

        dispatch( new ProcessLeaves($employeeId));

        $this->info("<fg=blue;bg=black> Done\n</>");
    }
}
