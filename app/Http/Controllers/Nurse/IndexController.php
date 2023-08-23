<?php

namespace App\Http\Controllers\Nurse;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Setting;
use App\Models\Petition;
use App\Models\SickLeave;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    private function save($model,$group_id,$person_id,$date){
        $model->group_id = $group_id;
        $model->person_id = $person_id;
        $model->date = $date;
        $model->accepted = false;
        $model->save();
    }

    public function index(){
        return view('nursePages/index',[
            'settingArray'=> Setting::getSettingbyUserId(Auth::user()->id),
        ]);
    }

    public function show(Request $request){

        $request->validate(
            [
                'year' => 'required|integer|numeric',
                'month' => 'required|integer|numeric',
            ]
        );
        $request = $request->all();

        $person_id = Auth::user()->id;
        $posts = Post::getScheduledDaybyPersonId($person_id,$request['year'],$request['month']);

        return response()->json($posts,200);
    }

    public function store(Request $request){

        if (User::checkUser(Auth::user()->id,Auth::user()->email) === false){
            return response("Nem megfelelő jogosultság", 403);
        }

        $data = json_decode($request->input('dates'),true);
        $group_id = User::getGroup_id(Auth::user()->id);
        $setting = Setting::getSettingbyUserId(Auth::user()->id);

        $currentPetiton = $setting->first()->currentPetitons;
        $currentMonthHoliday = $setting->first()->currentMonthHoliday;
        $currentYearHoliday = $setting->first()->currentYearHoliday;
        $currentSickLeave = $setting->first()->sickLeaves;

        foreach ($data as $d) {
            switch ($d['title']) {
                case 'Kérés':
                    if (Petition::searchDate(Auth::user()->id,$d['date']) === false &&
                        $setting->first()->maxPetitons > $currentPetiton){
                            $this->save(new Petition(),$group_id,Auth::user()->id,$d['date']);
                            $currentPetiton++;
                            $change = true;
                        }
                    break;
                case 'Szabadság':
                    if (Holiday::searchDate(Auth::user()->id,$d['date']) === false &&
                        $setting->first()->maxMonthHoliday > $currentMonthHoliday &&
                        $setting->first()->maxYearHoliday > $currentYearHoliday){
                            $this->save(new Holiday(),$group_id,Auth::user()->id,$d['date']);
                            $currentMonthHoliday++;
                            $currentYearHoliday++;
                            $change = true;
                        }
                    break;
                case 'Beteg Szabadság':
                    if (SickLeave::searchDate(Auth::user()->id,$d['date']) ===  false){
                        $this->save(new SickLeave(),$group_id,Auth::user()->id,$d['date']);
                        $currentSickLeave++;
                        $change = true;
                    }
                    break;
            }
        }

        //update setting table
        if ($change){
            $update = Setting::where('person_id',Auth::user()->id)->first();
            $update->currentPetitons = $currentPetiton;
            $update->currentMonthHoliday = $currentMonthHoliday;
            $update->currentYearHoliday = $currentYearHoliday;
            $update->SickLeaves = $currentSickLeave;
            $update->save();
            return response("Sikeres mentés", 200);
        }
        else{
            return response("Nem történt változás",204);
        }
    }

    public function getRestPeriods(){
        $holidayData = Holiday::getHolidaybyUserId(Auth::user()->id);
        $sickLeaveData = SickLeave::getSickLeavebyUserId(Auth::user()->id);
        $petitonData = Petition::getPetitionbyUserId(Auth::user()->id);
        return response()->json(["holiday" => $holidayData,"sickLeave" => $sickLeaveData, "petition" => $petitonData]);
        //return response()->json([$holidayData,$sickLeaveData,$petitonData]);
    }

}
