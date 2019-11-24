<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Setting;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\StartLotteryOne',
        'App\Console\Commands\StartLotteryTwo',
        'App\Console\Commands\StartLotteryThree',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // if (Setting::first()) {
        //     $time_prize1 = Setting::first()->time_of_prize1;
        //     $time_prize2 = Setting::first()->time_of_prize2;
        //     $time_prize3 = Setting::first()->time_of_prize3;
        //     $schedule->command('prize1:start')->dailyAt($time_prize1);
        //     $schedule->command('prize2:start')->dailyAt($time_prize2);
        //     $schedule->command('prize3:start')->dailyAt($time_prize3);
        // } else {
        //     echo 'Please set the time for prizes. ';
        // }
        
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
