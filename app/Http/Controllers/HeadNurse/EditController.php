<?php

namespace App\Http\Controllers\HeadNurse;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class EditController extends Controller
{
    public function index(){
        $getUserName = User::getUserName(Auth::user()->id);
        $shift = Post::getAllData(Auth::user()->id);
        return view('headNursePages/edit',['userName' => $getUserName]);
    }
}
