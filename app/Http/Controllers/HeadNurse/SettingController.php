<?php

namespace App\Http\Controllers\HeadNurse;

use App\Models\Setting;
use App\Models\schedule_settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Schema;

class SettingController extends Controller
{
    public function index(){
        $arr = Setting::getSettingbyAuth(Auth::user()->id);
        $check = schedule_settings::where('group_id',Auth::user()->id)->first();
        return view('headNursePages/setting',["setting" => $arr,'check' => $check]);
    }

    public function store(Request $request){
        $request->validate([
            'type' => ['required','string','max:30','regex:/^[a-zA-Z]+$/'],
            'number' => ['required', 'numeric'],
        ]);
        $data = $request->all();
        $settings = Setting::where('group_id',Auth::user()->id)->get();
        foreach ($settings as $setting){
            try {
                switch ($data['type']) {
                    case 'maxWorkerInOneDay':
                        $setting->maxNumberOfWorkersInOnday = $data['number'];
                        break;
                    case 'minWorkerInOneDay':
                        $setting->minNumberOfWorkersInOnday = $data['number'];
                        break;
                    case 'day':
                        $setting->numberOfDays = $data['number'];
                        break;
                    case 'night':
                        $setting->numberOfNights  = $data['number'];
                        break;
                    case 'holidayAllowanceForOneYear':
                        $setting->maxYearHoliday = $data['number'];
                        break;
                    case 'holidayAllowanceForOneMonth':
                        $setting->maxMonthHoliday = $data['number'];
                        break;
                    case 'restDayAllowanceForOneMonth':
                        $setting->maxPetitons = $data['number'];
                        break;
                }

                $setting->update();

            } catch (\Throwable $th) {
                return response("Sikertelen mentés");
            }

        }
        return response("Sikeres mentés");
    }

    public function storeFormCheckInputs(Request $request){
        $request->validate([
            'id' => ['required','string','max:5','regex:/^[a-z]+$/'],
            'value' => ['required','boolean'],
        ]);
        $data = json_decode($request->getContent(), true);
        $column = Str::snake($data['id']);
        if (Schema::hasColumn('schedule_settings',$column)) {
            $schedule_settings = schedule_settings::where('group_id',Auth::user()->id)->first();
            $schedule_settings->$column= $data['value'];
            $schedule_settings->update();
            return response("Sikeres mentés");
        }
        return response("Sikertelen mentés");
    }
}

