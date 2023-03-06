<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;

class nurseIndexController extends Controller
{
    public function show(){
        $headNurse = User::with('holiday')->findOrFail(Auth::user()->id);
        return view('nursePages/index',['holidays'=>$headNurse->holiday->pluck('date')
    ]);
    }

    //javascript kód
    public function getData(){
        $headNurse = User::with('holiday')->findOrFail(Auth::user()->id);
        $data = ['holidays'=>$headNurse->holiday->pluck('date')];
        return response()->json($data);
    }
}
