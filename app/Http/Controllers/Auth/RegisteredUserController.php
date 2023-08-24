<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\schedule_settings;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);



        $user = User::create([
            'group_id' => 0,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'headNurse',
        ]);

        event(new Registered($user));

        Auth::login($user);

        $user_id = Auth::user()->id;
        $user->group_id = $user_id;
        $user->update();

        schedule_settings::create([
            'group_id' => $user_id,
            'n' => 1,
            'e' => 1,
            'nn' => 1,
            'ee' => 1,
            'ne' => 1,
            'nne' => 1,
            'nee' => 1,
            'nnn' => 0,
            'eee' => 0,
            'folytonos' => 0
        ]);

        Setting::create([
            'group_id' => $user_id,
            'person_id' => $user_id,
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
