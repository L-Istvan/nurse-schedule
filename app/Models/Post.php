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

    static public function getAllData($group_id){
        $user = new User();
        return self::leftJoin('users','posts.person_id', '=', 'users.id')
        ->where('posts.group_id',$group_id)
        ->select('date','position','name')
        ->get();
    }
}
