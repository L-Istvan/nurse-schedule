<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Holiday;
use App\Models\Setting;
use App\Models\Petition;
use App\Models\SickLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;

class nurseIndexController extends Controller
{
    public function show(){
        return view('nursePages/index',[
            'settingArray'=> Setting::getSettingbyUserId(Auth::user()->id),
    ]);
    }

    public function getData(){
        $holidayData = Holiday::getHolidaybyUserId(Auth::user()->id);
        $sickLeaveData = SickLeave::getSickLeavebyUserId(Auth::user()->id);
        $petitonData = Petition::getPetitionbyUserId(Auth::user()->id);
        return response()->json([$holidayData,$sickLeaveData,$petitonData]);
    }

    /**
     * This function is primarily designed for the 'store' function,
     * which can save data to the database
     * @param [class] Holiday()/Petiton()/SickLeave() $model
     * @param [integer] $user_id
     * @param [integer] $person_id
     * @param [date] $date
     * @return void
     */
    function save($model,$user_id,$person_id,$date){
        $model->user_id = $user_id;
        $model->person_id = $person_id;
        $model->date = $date;
        $model->accepted = false;
        $model->save();
    }

    /**
     * If the user adds new events to the calender,
     * this function checks it
     * check: Is there an event that day
     * check: does not exceed the maximums
     * @param Request $request
     * @return response
     */
    public function store(Request $request){
        $data = json_decode($request->getContent(), true);
        $user_id = 1; //WAIT PETITONS TABLE
        $setting = Setting::getSettingbyUserId(Auth::user()->id);

        $currentPetiton = $setting->first()->currentPetitons;
        $currentMonthHoliday = $setting->first()->currentMonthHoliday;
        $currentYearHoliday = $setting->first()->currentYearHoliday;
        $currentSickLeave = $setting->first()->SickLeaves;

        foreach ($data as $d) {
            switch ($d['title']) {
                case 'Kérés':
                    if (Petition::searchDate(Auth::user()->id,$d['date']) === false &&
                        $setting->first()->maxPetitons > $currentPetiton){
                            self::save(new Petition(),$user_id,Auth::user()->id,$d['date']);
                            $currentPetiton++;
                        }
                    break;
                case 'Szabadság':
                    if (Holiday::searchDate(Auth::user()->id,$d['date']) === false &&
                        $setting->first()->maxMonthHoliday > $currentMonthHoliday &&
                        $setting->first()->maxYearHoliday > $currentYearHoliday){
                            self::save(new Holiday(),$user_id,Auth::user()->id,$d['date']);
                            $currentMonthHoliday++;
                            $currentYearHoliday++;
                        }
                    break;
                case 'Beteg Szabadság':
                    if (SickLeave::searchDate(Auth::user()->id,$d['date']) ===  false){
                        self::save(new SickLeave(),$user_id,Auth::user()->id,$d['date']);
                        $currentSickLeave++;
                    }
                    break;
            }
        }

        //update setting table
        $update = Setting::where('person_id',Auth::user()->id)->first();
        $update->currentPetitons = $currentPetiton;
        $update->currentMonthHoliday = $currentMonthHoliday;
        $update->currentYearHoliday = $currentYearHoliday;
        $update->SickLeaves = $currentSickLeave;
        $update->save();
        return response("ok", 200);
    }

}
