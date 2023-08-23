<?php

namespace App\Http\Controllers\HeadNurse;

use Exception;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Genetic;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;

class GeneticController extends Controller
{
    public function store($arr,$year,$month){
        foreach($arr as $id => $shifts){
            foreach($shifts as $day => $shift)
            try {
                if ($shift == 2){
                    $post = Post::firstOrCreate([
                        'group_id' => Auth::user()->id,
                        'person_id' => $id,
                        'date' => $year."-".$month."-".$day,
                        'position' => 2
                    ]);
                }

                if ($shift == 1 ){
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
                return false;
            }
        }
        return true;
    }

    /**
     * @param Request $request [year,month's number,the days of the month] These values mean the actual time of the board.
     * @return void
     */
    public function genetic(Request $request){

        $request->validate([
            'year' => 'required|integer|numeric',
            'month' => 'required|integer|numeric',
            'numberOfDaysInMonth' => 'required|integer|numeric'
        ]);
        $request = $request->all();

        $year = $request['year'];
        $month = $request['month'];
        $last_day_in_month = $request['numberOfDaysInMonth'];

        $genetic = new Genetic($year,$month,$last_day_in_month,200,0.2,10);
        $result = $this->store($genetic->main(),$year,$month);

        if($result === false) return response()->json('Hiba történt a mentés során!', 500);
        return response()->json('Az új beosztás elkészült!', 200);
    }

    public function writeToFile($arr)
    {
        $file = fopen('/home/ubuntu/Dokumentumok/file.txt', 'w');
        foreach ($arr as $item){
            foreach($item as $id){
                foreach ($id as $day){
                    fwrite($file, $day);
                }
                fwrite($file,PHP_EOL);
            }
            fwrite($file,"-----------------------------------".PHP_EOL);
        }

        fclose($file); // Fájl bezárása

        return 'A tömb kiírása sikeresen megtörtént.';
    }
}
