<?php

namespace App\Http\Controllers\HeadNurse;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\Events\Validated;
use Barryvdh\Debugbar\Facades\Debugbar;

use function Symfony\Component\String\b;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    public function index(){
        $getUser = User::getEmailandNamebyUser(Auth::user()->id);
        $shift = Post::getAllData(Auth::user()->id);
        return view('headNursePages/edit',["getUser" => $getUser]);
    }

    public function store(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            '*.email' => ['required', 'string', 'email', 'max:255'],
            '*.date' => ['required','string','date'],
            '*.shift' => ['required','numeric','in:1,2'],
        ]);

        if ($validator->passes()) {

            try {
                foreach($data as $item) {
                    $post = new Post(Auth::user()->id,100,$item['date'],$item['shift']);
                }($data);
            } catch (\Throwable $th) {
                //throw $th;
            }
            return response('Sikeres mentés',200);
        } else {
            $errors = $validator->errors()->all();
            Debugbar::error($errors);
        }
        return response($errors,500);
    }
}
