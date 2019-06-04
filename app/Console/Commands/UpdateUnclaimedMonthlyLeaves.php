<?php

namespace App\Console\Commands;

use App\Jobs\UpdateUnclaimedMonthlyLeaves as ProcessUnclaimedMonthly;
use Illuminate\Console\Command;

class UpdateUnclaimedMonthlyLeaves extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaves:update-monthly-unclaimed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'adjust leaves entitlement for unclaimed in previous months';

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

        $this->info("<fg=blue;bg=black> Start</>");

        dispatch( new ProcessUnclaimedMonthly());

        $this->info("<fg=blue;bg=black> Done\n</>");
    }
}
