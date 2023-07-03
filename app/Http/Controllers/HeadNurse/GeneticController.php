<?php

namespace App\Http\Controllers\HeadNurse;

use Exception;
use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Genetic;
use App\Http\Controllers\Chromosome;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GeneticTools;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Utils\StringSearch;

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
            }
        }
    }

    /**
     * @param Request $request [year,month's number,the days of the month] These values mean the actual time of the board.
     * @return void
     */
    public function genetic(Request $request){
        $year = $request[0];
        $month = $request[1];
        $last_day_in_month = $request[2];

        $g = new Genetic($year,$month,$last_day_in_month,200,0.2,10);
        //$g->main();
        //$this->writeToFile($g->main());
        $this->store($g->main(),$year,$month);
        return response("Az új beosztás elkészült");
    }

    public function writeToFile($arr)
    {
        $file = fopen('/home/ubuntu/Dokumentumok/file.txt', 'w'); // Nyitás írás módra
        foreach ($arr as $item){
            foreach($item as $id){
                foreach ($id as $day){
                    fwrite($file, $day); // Kiírás a fájlba
                }
                fwrite($file,PHP_EOL);
            }
            fwrite($file,"-----------------------------------".PHP_EOL);
        }

        fclose($file); // Fájl bezárása

        return 'A tömb kiírása sikeresen megtörtént.';
    }
}
