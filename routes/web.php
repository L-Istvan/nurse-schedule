<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Nurse\IndexController;
use App\Http\Controllers\HeadNurse\AddEmployeeController;
use App\Http\Controllers\UniqueLinkController;
use App\Models\UniqueLink;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth');

Route::middleware('auth','verified','nurse')->group(function(){
    Route::get('/', 'App\Http\Controllers\Nurse\IndexController@show');
    Route::get('/getdata', [IndexController::class, 'getData']);
    Route::post('/sendCalendarData',[IndexController::class,'store']);
});

Route::middleware('auth','verified','headNurse')->group(function(){
    Route::get('/Főnővér',function(){
        return view('/headNursePages/index');
    })->name('/headNursePages/index');
    Route::get('/edit',function(){
        return view('/headNursePages/edit');
    });
    Route::get('/addEmployer',function(){
        return view('/headNursePages/addEmployer');
    });
    Route::get('/send',function(){
        mail('byroned100@gmail.com', 'valami', 'dsfds', 'From: nurseschedules@nurseschedules.nhely.hu');
    });
    Route::post('/addNurse',[AddEmployeeController::class,'store']);
    Route::post('/sendInputEmployee',[UniqueLinkController::class,'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
