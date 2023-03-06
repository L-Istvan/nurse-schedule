<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Holiday;
use App\Models\SickLeave;
use App\Models\Petition;
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
        $nameHoliday = User::with('holiday')->findOrFail(Auth::user()->id);
        $nameSickLeave = User::with('sickLeave')->findOrFail(Auth::user()->id);
        $namePetition = User::with('petition')->findOrFail(Auth::user()->id);
        $holidayData = ['holidays'=>$nameHoliday->holiday->pluck('date')];
        $sickLeaveData = ['SickLeave'=>$nameSickLeave->sickLeave->pluck('date')];
        $petitonData = ['Petition'=>$namePetition->petition->pluck('date')];
        return response()->json([$holidayData,$sickLeaveData,$petitonData]);
    }
}
