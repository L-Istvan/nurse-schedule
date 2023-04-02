<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Models\UniqueLink;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Barryvdh\Debugbar\Facades\Debugbar;

class AddEmployeeController extends Controller
{

    public function create($link): View
    {
        $email = UniqueLink::searchEmail($link);
        session()->put('link',$link);
        if (UniqueLink::searchLik($link)){
            return view('auth.registerLink',['email' => $email]);
        }
        else abort(404);
    }

    public function store(Request $request){
        $link = session()->get('link');
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = UniqueLink::getData($link)->first();

        try{
            $user = User::create([
                'group_id' => $data->group_id,
                'name' => $request->name,
                'mobile_number' => '',
                'email' => $data->email,
                'password' => Hash::make($request->password),
                'role' => 'nurse',
                'education' => $data->education,
                'rank' => $data->rank,
            ]);
        }catch(\Exception $ex){
            $errorCode = $ex->getCode();
            if ($errorCode == 23000){
                return response('Az email cím már regisztrálva van.');
            }
        }

        try{
            event(new Registered($user));
            return response('Sikeres regisztráció',200);
        }catch(\Exception $ex){
            $errorCode = $ex->getCode();
            return response("valami hiba történt, próbálja meg később");
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
