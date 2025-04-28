<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\User;

class Kernel extends ConsoleKernel
    {
        protected function schedule(Schedule $schedule): void
        {
            $schedule->call(function () {
                User::where('time_frame', 'Temporary')
                    ->whereNotNull('time_limit')
                    ->where('time_limit', '<', now())
                    ->get()
                    ->each->expireTemporaryRole(); //  Uses model method
            })->everyOneMinutes(); // Run more frequently
        }

        protected function commands(): void
        {
            $this->load(__DIR__.'/Commands');
            require base_path('routes/console.php');
        }

        
    }