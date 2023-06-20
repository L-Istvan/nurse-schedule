<?php

namespace App\Http\Controllers\HeadNurse;

use Exception;
use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\GeneticTools;
use App\Http\Controllers\Chromosome;
use App\Http\Controllers\Genetic;

class GeneticController extends Controller
{
    public function store($arr,$year,$month){
        foreach ($arr as $day => $values){
            foreach ($values as $id){
                try {
                    if (0 < $id){
                        $post = Post::firstOrCreate([
                            'group_id' => Auth::user()->id,
                            'person_id' => $id,
                            'date' => $year."-".$month."-".$day,
                            'position' => 2
                        ]);
                    }

                    else{
                        $post = Post::firstOrCreate([
                            'group_id' => Auth::user()->id,
                            'person_id' => abs($id),
                            'date' => $year."-".$month."-".$day,
                            'position' => 1
                        ]);
                    }
                } catch (Exception $ex) {
                    Debugbar::error("HIBA");
                    Debugbar::info($ex);
                }
            }
        }
    }


    //kezdezi chromosome létrehozása
    public function createPeliminaryChromosome($sorted_user,$monthDayNumber,$max,$min){
        //NAPPAL : 7
        //ÉJSZAKA : 6
        $chromosome = [];

        foreach ($sorted_user as $id => $values){
            $free = [];

            // bele töltés szabadokba
            foreach ($values as $day =>$value ){
                if ($value == 1) $free[] = $day; // free[3,4,5,6,7,11,12]
            }

            // óra szám kiszámolása

            // nappal 7 (pozitiv id)
            for ($i=0;$i<7;$i++){
                $randomIndex = array_rand($free);
                $selectedElement = $free[$randomIndex];
                unset($free[$randomIndex]);
                $chromosome[$selectedElement][] = $id;
            }

            //éjszaka 6 (negatív id)
            for ($i=0;$i<6;$i++){
                $randomIndex = array_rand($free);
                $selectedElement = $free[$randomIndex];
                unset($free[$randomIndex]);
                $chromosome[$selectedElement][] = $id * -1;
            }

        }
        return $chromosome;
    }

    public function createPeliminaryPopulation($users,$canWorkOnThisDay,$population_size,$monthDayNumber,$max,$min,$days,$nights){
        $chromosome = [];
        $population = [];
        //main loop
        for ($i=0;$i<$population_size;$i++){ //population
            for($m=0;$m<$monthDayNumber;$m++){ //28 29 30 31
                $chromosome[$m] = Arr::random($users);
            }
            $population[] = $chromosome;
        }
        return $population;
    }

    /**
     * @param Request $request [year,month's number,the days of the month] These values mean the actual time of the board.
     * @return void
     */
    public function genetic(Request $request){
        $year = $request[0];
        $month = $request[1];
        $last_day_in_month = $request[2];

        $genetic = new Genetic();
        Debugbar::info($genetic->workTime(22,0,0    ));

        return response("Az új beosztás elkészült");
    }
}
