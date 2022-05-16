<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $todaysDate = date_create(date("Y-m-d"));
            $results = DB::select('select * from location  where DateFinLoc >  :DateFinLoc  and Status =:Status and Note=:Note', ['DateFinLoc' => $todaysDate, 'Status' => "Accepter", 'Note' => 'non']);
            $res = json_decode(json_encode($results), true);
            foreach ($res as $dates) {
                $results = DB::select('UPDATE location set Note=:Note where IdLocation  =:IdLocation   ', ['Note' => "Waiting", 'IdLocation' => $dates["IdLocation"]]);
                if ($results) {
                    echo "success";
                }
                var_dump($dates);
            }
            echo 'basic message';
        })
            ->everyMinute();
    }

    // public function
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}