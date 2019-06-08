<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\DailyDeduction::class,
        Commands\BackupDatabase::class,
        Commands\MonthlyInvoice::class,
        Commands\Notification::class,
        Commands\NewsLetterJob::class,
		
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('daily:deduction')->hourly();
      //   $schedule->command('db:backup')->hourly();
        // $schedule->command('notify:mail')->hourly();
        // $schedule->command('monthly:Invoice')->monthlyOn(2, '15:00');
        // $schedule->command('daily:newsletter')->everyFiveMinutes();
		 
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
