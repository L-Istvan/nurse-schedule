<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** columns explanation
 * id()
 * foreignId('group_id') : A head nurse's group
 * integer("person_id) : Employee ID
 * date('date') : Sick day
 * boolean('accpeted') : If head nurse accepts
 */
class SickLeave extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function getSickLeavebyUserId($person_id){
        return self::where('person_id',$person_id)->pluck('date');
    }

    /**
     * @param [integer] $person_id
     * @param [date] $date
     * @return boolean true if there is a match
     */
    public static function searchDate($person_id,$date){
        return self::where('person_id', $person_id)->where('date', $date)->exists();
    }

    public static function getSickLeavebyMonthAndUserId($person_id,$month){
        return self::where('person_id',$person_id)
        ->whereMonth('date', $month)
        ->pluck('date');
    }

    /**
     * Returns the person_id and day number, taking into account given year and month.
     *
     * @param [int] $group_id
     * @param [int] $year
     * @param [int] $month
     * @return array person_id and date
     */
    public static function getSickLeaveByGroupId($group_id,$year,$month){
        return self::where('group_id',$group_id)
        ->whereYear('date',$year)
        ->whereMonth('date',$month)
        ->select('person_id','date')
        ->get();
    }
}
