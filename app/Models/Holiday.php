<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** columns explanation
 * id()
 * foreignId('user_id') : A head nurse's group
 * integer("person_id) : Employee ID
 * date('date') : Holiday day
 * boolean('accpeted') : If head nurse accepts
 */

class Holiday extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function getHolidaybyUserId($person_id){
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
}
