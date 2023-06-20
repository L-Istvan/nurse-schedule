<?php

namespace App\Http\Controllers\HeadNurse;

use Exception;
use App\Models\Post;
use App\Models\Petition;
use App\Models\Holiday;
use App\Models\SickLeave;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    public function index(){
        $getUser = User::getUserIdAndNamebyUser(Auth::user()->id);
        return view('headNursePages/edit',["getUser" => $getUser]);
    }

    public function store(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            '*.id' => ['required', 'numeric'],
            '*.date' => ['required','string','date'],
            '*.shift' => ['required','numeric','in:1,2'],
        ]);

        if ($validator->passes()) {
            try {
                foreach($data as $item) {
                    $post = Post::firstOrCreate([
                        'group_id' => Auth::user()->id,
                        'person_id' => $item['id'],
                        'date' => $item['date'],
                        'position' => $item['shift']
                    ]);
                }
            } catch (Exception $ex) {
                Debugbar::info($ex);
            }
            return response('Sikeres mentés',200);
        } else {
            $errors = $validator->errors()->all();
        }
        return response($errors,500);
    }

    public function destroy(Request $request){
        $data = $request->all();
        try {
            Post::deleteRow(Auth::user()->id,$data[0],$data[1]);
            return response('Sikeres törlés',200);
        } catch (Exception $ex) {
            return response('Sikertelen törlés');
        }
    }

    public function tableLoadDay(Request $request){
        $year = $request['year'];
        $month = $request['month'];
        $days = Post::getDay(Auth::user()->id,$year,$month);
        return response()->json([$days],200);
    }

    public function tableLoadNight(Request $request){
        $year = $request['year'];
        $month = $request['month'];
        $nights = Post::getNight(Auth::user()->id,$year,$month);

        return response()->json([$nights],200);
    }

    public function table_load_petition(Request $request){
        $year = $request['year'];
        $month = $request['month'];
        $petitions = Petition::getPetitionByGroupId(Auth::user()->id,$year,$month);

        return response()->json([$petitions],200);
    }

    public function tableLoadHoliday(Request $reques){
        $year = $reques['year'];
        $month = $reques['month'];
        $holidays = Holiday::getHolidayByGroupId(Auth::user()->id,$year,$month);
        return response()->json([$holidays],200);
    }

    public function tableLoadSickLeave(Request $reques){
        $year = $reques['year'];
        $month = $reques['month'];
        $sickLeaves = SickLeave::getSickLeaveByGroupId(Auth::user()->id,$year,$month);
        return response()->json([$sickLeaves],200);
    }
}
