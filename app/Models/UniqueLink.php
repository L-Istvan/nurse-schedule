<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Pest\Laravel\get;

/**
 * columns explanation
 *  id()
 *  string('link'): table's row will be deleted after 24 hours
 *  tinyInteger('value') : false
 *  integer('group_id')
 *  string('name')
 *  string('email')->unique()
 *  enum('education',[...])
 *  string('rank')
 */

class UniqueLink extends Model
{
    use HasFactory;

    static public function searchLik($link){
        return self::where('link',$link)->where('value','false')->exists();
    }

    static public function searchEmail($link){
        return self::where('link',$link)->pluck('email');
    }

    static public function getData($link){
        if (self::where('link',$link)->where('value','false')->exists())
            return self::where('link',$link)->get();
        else return null;
    }

}
