<?php

namespace App\Http\Controllers;

use App\Models\UniqueLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Debugbar\Facades\Debugbar;

use function Pest\Laravel\json;

class UniqueLinkController extends Controller
{
    public function store(Request $request){
        $data = json_decode($request->getContent(),true);
        if ($data['inputName'] == null || $data['inputName'] == ''
            || $data['inputEmail'] == null || $data['inputEmail'] == ''){
                return response()->json(['message'=> 'Beosztáson kivül minden mező kitöltése szükséges.'],500);
        }
        $link = Str::random(16);
        $uniqueLink = new UniqueLink();
        $uniqueLink->link = $link;
        $uniqueLink->group_id = Auth::user()->id;
        $uniqueLink->name = $data['inputName'];
        $uniqueLink->email = $data['inputEmail'];
        $uniqueLink->education = $data['selectedEducation'];
        $uniqueLink->rank = $data['inputRank'];
        try {
            $uniqueLink->save();
            mail($data['inputEmail'], 'NurseSchedules', 'Regisztrácios link : '.$link, 'From: nurseschedules@nurseschedules.nhely.hu');
            return response()->json(['message' => 'Sikeresen elküdve a regisztráció link.'],200);
        } catch (\Illuminate\Database\QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) return response()->json(['message'=> 'Erre az email címre már érkezett regisztrációs link, próbálja meg később'],500);
            else if($errorCode == 1265) return response()->json(['message'=> 'Sikeretelen adatbevitel, próbálja meg újra'],500);
            else{
                return response()->json(['message' => 'Sikertelen regisztráció kűldés, próbálja meg később'],500);
            }
        }
    }

}
