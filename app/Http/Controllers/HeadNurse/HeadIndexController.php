<?php

namespace App\Http\Controllers\HeadNurse;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HeadIndexController extends Controller
{
    public function getShift(){
        $shift = Post::getAllData(Auth::user()->id);
        return response()->json($shift);
    }
}
