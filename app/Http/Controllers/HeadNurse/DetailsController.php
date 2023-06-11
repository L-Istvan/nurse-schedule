<?php

namespace App\Http\Controllers\HeadNurse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facades\Debugbar;

class DetailsController extends Controller
{
    public function index(){
        return view('/headNursePages/details');
    }
}
