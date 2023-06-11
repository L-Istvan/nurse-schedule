<?php

namespace App\Http\Controllers\HeadNurse;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Holiday;
use App\Models\SickLeave;
use App\Models\Petition;
use App\Models\Setting;
use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facades\Debugbar;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class GeneticController extends Controller
{
    public function store($year,$month,$arr){
        try {
            foreach($arr as $key => $item) {
                $post = Post::firstOrCreate([
                    'group_id' => Auth::user()->id,
                    'person_id' => $item,
                    'date' => $year."-".$month."-".$key,
                    'position' => 2
                ]);
            }
        } catch (Exception $ex) {
            Debugbar::info($ex);
        }
    }


    // [1.id][1] -> első idének az első napja! nem a 2.!!!
    public function updateCanWorkOnThisDay($month,$monthDayNumber){
        $canWorkOnThisDay = [];
        $users = User::getPersonId(Auth::user()->id);
        foreach ($users as $key => $user){

            for ($i=0; $i<$monthDayNumber; $i++){
                $canWorkOnThisDay[$user][] = 1;
            }

            //Petiton's value = 0
            $petitions = Petition::getPetitionbyHolidayAndUserId($user,$month);
            foreach ($petitions as $petition){
                $arr = explode("-",$petition);
                $canWorkOnThisDay[$user][intval($arr[2])] = 0;
            }

            //holiday's value = -1
            $holidays = Holiday::getHolidaybyMonthAndUserId($user,$month);
            foreach($holidays as $holiday){
                $arr = explode("-",$holiday);
                $canWorkOnThisDay[$user][intval($arr[2])] = -1;
            }

            //SickLeave's value = -2
            $sickLeaves = SickLeave::getSickLeavebyMonthAndUserId($user,$month);
            foreach($sickLeaves as $sickLeave){
                $arr = explode("-",$sickLeave);
                $canWorkOnThisDay[$user][intval($arr[2])] = -2;
            }
        }
        return $canWorkOnThisDay;
    }

    /**
     * @param Request $request [year,month's number,the days of the month] These values mean the actual time of the board.
     * @return void
     */
    public function genetic(Request $request){
        $data = $request;
        $users = User::getPersonId(Auth::user()->id);
        $users = $users->toArray();
        $canWorkOnThisDay = self::updateCanWorkOnThisDay($data[1],$data[2]);
        $chromosome = [];
        for($i=1;$i<=$data[2];$i++){
            $chromosome[$i] = Arr::random($users);
        }

        //save to database
        self::store($data[0],$data[1],$chromosome);
        Debugbar::info($chromosome);
        return response("Az új beosztás elkészült");
    }
}
