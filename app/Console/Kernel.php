<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    protected $commands = [
        \App\Console\Commands\CheckPendingOrders::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('orders:check-pending')->everyMinute();
    }
}
