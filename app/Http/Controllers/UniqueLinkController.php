<?php

namespace App\Http\Controllers;

use App\Models\UniqueLink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UniqueLinkController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'inputName' => ['required', 'string', 'max:255'],
            'inputEmail' => ['required', 'string', 'email', 'max:255'],
            'selectedEducation' => ['required','string','max:255'],
            'inputRank' => ['nullable','string','max:255'],
        ],
        [
            'inputName.required' => "Nem adott meg nevet.",
            'inputEmail.required' => "Nem adott meg email címet",
            'selectedEducation.required' => "Nincs kiválasztva a végzettség.",
            'inputEmail.email' => "Érvénytelen email formátum.",
        ]);

        $link = Str::random(16);
        $uniqueLink = new UniqueLink();
        $uniqueLink->link = $link;
        $uniqueLink->group_id = Auth::user()->id;
        $uniqueLink->name = $request->inputName;
        $uniqueLink->email = $request->inputEmail;
        $uniqueLink->education = $request->selectedEducation;
        $uniqueLink->rank = $request->inputRank;

        try {
            $uniqueLink->save();
            mail($request->inputEmail, 'Apolobeostas regisztráció link', 'Regisztrácios link : nurseschedules.nhely.hu/registerLink/'.$link, 'From: info@apolobeosztas.hu');
        } catch (\Illuminate\Database\QueryException $ex) {
            $errorCode = $ex->errorInfo[1];
            if ($errorCode == 1062) return response()->json(['message'=> 'Erre az email címre már érkezett regisztrációs link, próbálja meg később'],500);
            else if($errorCode == 1265) return response()->json(['message'=> 'Sikeretelen adatbevitel, próbálja meg újra'],500);
            else if($errorCode == 422) return response()->json(['message' => 'Név vagy Email mező üresen maradt.'],422);
            else{
                return response()->json(['message' => 'Sikertelen regisztráció kűldés, próbálja meg később'],500);
            }
        }

        return response()->json(['message' => 'Sikeresen elküdve a regisztráció link.'],200);
    }

}
