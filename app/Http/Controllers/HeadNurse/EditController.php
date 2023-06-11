<?php

namespace App\Http\Controllers\HeadNurse;

use Exception;
use App\Models\Post;
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

    public function tableLoad(Request $request){
        $data = $request->all();
        $shift = Post::getShift(Auth::user()->id);
        return response()->json([$shift],200);
    }
}
