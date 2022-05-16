<?php

namespace App\Console\Commands;

use Illuminate\Console\Scheduling\Schedule;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckLocation extends Command
{

    protected $signature = 'Location:daily';


    protected $description = 'Verification de la fin de la location';

    public function handle()
    {
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
    }
}