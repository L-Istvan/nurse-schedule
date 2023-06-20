<?php

namespace App\Http\Controllers\HeadNurse;

use App\Models\Setting;
use Illuminate\Http\Request;
use function Pest\Laravel\json;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;

class SettingController extends Controller
{
    public function index(){
        $arr = Setting::getSettingbyAuth(Auth::user()->id);
        return view('headNursePages/setting',["setting" => $arr]);
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
}

