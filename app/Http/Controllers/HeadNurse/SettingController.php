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
            'type' => ['required','string','ma x:30','regex:/^[a-zA-Z]+$/'],
            'number' => ['required', 'numeric'],
        ]);
        $data = $request->all();
        $setting = Setting::where('group_id',1)->first();
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
            return response("Sikeres mentés");

        } catch (\Throwable $th) {
            //throw $th;
        }
        return response("Sikertelen mentés");

    }
}

