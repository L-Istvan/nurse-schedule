<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Nurse\IndexController;
use App\Http\Controllers\HeadNurse\addEmployer;
use App\Http\Controllers\UniqueLinkController;
use App\Http\Controllers\HeadNurse\HeadIndexController;
use App\Http\Controllers\HeadNurse\EditController;
use App\Http\Controllers\HeadNurse\DetailsController;
use App\Http\Controllers\HeadNurse\SettingController;
use App\Http\Controllers\HeadNurse\GeneticController;

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth');

Route::middleware('auth','verified','nurse')->group(function(){
    Route::get('/',[IndexController::class,'index'])->name('indexController.index');
    Route::get('/getRestPeriods', [IndexController::class, 'getRestPeriods'])->name('indexController.getRestPeriods');
    Route::post('/sendCalendarData',[IndexController::class,'store'])->name('indexController.store');
    Route::post('/getScheduledDates',[IndexController::class,'show'])->name('indexController.show');
});

Route::middleware('auth','verified','headNurse')->group(function(){
    Route::get('Főnővér',[EditController::class,'index'])->name('edit');
    Route::post('sendInputEmployee',[UniqueLinkController::class,'store']);
    Route::get('addEmployer',[addEmployer::class,'index'])->name("addEmployer");
    Route::post('delete',[addEmployer::class,'destroy'])->name("delete");
    Route::get('getShift',[HeadIndexController::class,'getShift']);
    Route::post('saveTableCells',[EditController::class,'store']);
    Route::get('tableLoad',[EditController::class,'tableLoad']);
    Route::get('details',[DetailsController::class,'index']);
    Route::post('deleteActTable',[EditController::class,'destroy']);
    Route::get('setting ',[SettingController::class,'index'])->name('setting.index');
    Route::post('create_schedule',[GeneticController::class,'genetic']);
    Route::post('saveSettingValue',[SettingController::class,'store'])->name('setting.store');
    Route::post('table_load_petition',[EditController::class,'table_load_petition']);
    Route::post('tableLoadHoliday',[EditController::class,'tableLoadHoliday']);
    Route::post('tableLoadSickLeave',[EditController::class,'tableLoadSickLeave']);
    Route::post('tableLoadDay',[EditController::class,'tableLoadDay']);
    Route::post('tableLoadNight',[EditController::class,'tableLoadNight']);
    Route::post('saveFormCheckInputs',[SettingController::class,'storeFormCheckInputs']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
