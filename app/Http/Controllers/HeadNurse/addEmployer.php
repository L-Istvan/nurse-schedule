<?php

namespace App\Http\Controllers\HeadNurse;

use Exception;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;

class addEmployer extends Controller
{
    public function index()
    {
        return view('/headNursePages/addEmployer',
        ['users' => User::getUserbyGroupId(Auth::user()->id)]);
    }

    public function destroy(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'submit_button' => ['required', 'string', 'email', 'max:255'],
            ],
            [
                'name.required' => "Nem található a név.",
                'submit_button.required' => "Nem található az email cím.",
                'submit_button.email' => "Az email cím nem megfelelő formátumú.",
            ]
        );
        try {
            User::deleteUserbyEmailAndName($request->submit_button, $request->name);
            return redirect(route('addEmployer'))->with('succes', 'Sikeres regisztráció');
        } catch (Exception $e) {
            return redirect(route('addEmployer'))->with('err', 'Sikertelen törlés.');
        }
    }

    public function getAllData()
    {
        $getAllData = Post::getAllData(Auth::user()->id);
        return response()->json($getAllData, 200);
    }
}
