<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


use App\Helpline;
use App\AppSettings;

use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $delete_after_helpline_hotline = AppSettings::where('name', '=', 'delete_after_helpline_hotline')->first();

            if ($delete_after_helpline_hotline && (int)($delete_after_helpline_hotline->value)>0){

                $date = Carbon::now()->subMonths($delete_after_helpline_hotline->value);

                Helpline::softDelete($date);

            }


        })->everyMinute();
        //->dailyAt('5:00');

        //->everyMinute();
         
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
        $this->load(__DIR__.'/Commands');
    }
}
