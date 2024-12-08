<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Schedule;

class RemoveExpiredSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-expired-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove schedules that have already ended';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Schedule::where('schedule_time', '<', now())->delete();
        $this->info('Expired schedules removed successfully.');
    }
}
