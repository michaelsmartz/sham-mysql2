<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FlushDashboardCachedQueries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $summary;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->summary = [];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            Cache::tags('dashboard')->flush();
            $this->summary = ['dashboard' => ['cache' => 'flushed']];

        } catch (Exception $exception) {
            
            DB::table('job_logs')->insert([
                'message' => 'Exception',
                'level' => 900,
                'context' => 'FlushDashboardCachedQueries',
                'extra' => json_encode($exception),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

    }

    public function displayName()
    {
        return 'App\\Jobs\\FlushDashboardCachedQueries';
    }
}
