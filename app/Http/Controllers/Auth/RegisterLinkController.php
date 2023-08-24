<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use App\Models\UniqueLink;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisterLinkController extends Controller
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
        }catch(\Exception $ex){
            $errorCode = $ex->getCode();
            return response("valami hiba történt, próbálja meg később");
        }

        Setting::create([
            'group_id' => $data->group_id,
            'person_id' => $user->id,
            'maxYearHoliday' => 31,
            'currentYearHoliday' => 0,
            'maxMonthHoliday' => 10,
            'currentMonthHoliday' => 0,
            'maxPetitons' => 5,
            'currentPetitons' => 0,
            'sickLeaves' => 400,
            'numberOfDays' => 7,
            'numberOfNights' => 6,
            'maxNumberOfWorkersInOnday' => 4,
            'minNumberOfWorkersInOnday' => 1,
        ]);

        return redirect(RouteServiceProvider::HOME);
    }
}
