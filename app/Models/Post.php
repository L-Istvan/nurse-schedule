<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/** columns explanation
 * id()
 * foreignId('group_id') : A head nurse's group
 * integer("person_id) : Employee ID
 * date('date') : When nurse work.
 * integer('position') : Values can be such as day shift:1 , night shift : 0
 */

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'person_id',
        'date',
        'position',
    ];

    /**
     * Returns the person_id, date and position(day),
     * taking into account given year and month.
     *
     * @param [int] $group_id
     * @param [int] $year
     * @param [int] $month
     * @return array person_id, date, postition(day)
     */
    static public function getDay($group_id,$year,$month){
        return self::where('group_id',$group_id)
        ->where('position',2)
        ->whereYear('date',$year)
        ->whereMonth('date',$month)
        ->select('person_id','date','position')
        ->get();
    }

    /**
     * Returns the person_id, date and position(night),
     * taking into account given year and month.
     *
     * @param [int] $group_id
     * @param [int] $year
     * @param [int] $month
     * @return array person_id, date, postition(night)
     */
    static public function getNight($group_id,$year,$month){
        return self::where('group_id',$group_id)
        ->where('position',1)
        ->whereYear('date',$year)
        ->whereMonth('date',$month)
        ->select('person_id','date','position')
        ->get();
    }

    public static function getScheduledDaybyPersonId($person_id,$year,$month){
        return self::where('person_id',$person_id)
            ->whereYear('date',$year)
            ->whereMonth('date',$month)
            ->select('date','position')
            ->get();
    }

    static public function getAllData($group_id){
        $user = new User();
        return self::leftJoin('users','posts.person_id', '=', 'users.id')
        ->where('posts.group_id',$group_id)
        ->select('date','position','name')
        ->get();
    }

    static public function checkExist($person_id,$date,$shift,){
        return self::where('person_id',$person_id)
        ->where('date',$date)
        ->where('shift',$shift)
        ->exists();
    }

    static public function deleteRow($group_id,$year,$month){
        return self::where('group_id',$group_id)
        ->whereYear('date',$year)
        ->whereMonth('date',$month)
        ->delete();
    }
}
