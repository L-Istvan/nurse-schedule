<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function getSettingbyUserId($person_id){
        return self::where('person_id',$person_id)->get();
    }



    public static function  getSettingbyAuth($group_id){
        return self::where('group_id',$group_id)
        ->select('maxYearHoliday','maxMonthHoliday','maxPetitons','numberOfDays','numberOfNights','maxNumberOfWorkersInOnday','minNumberOfWorkersInOnday')
        ->get();
    }

}
