<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', 'App\Http\Controllers\nurseIndexController@show');
    Route::get('/getdata', [App\Http\Controllers\nurseIndexController::class, 'getData']);
});



Route::get('/welcome', function () {
    return view('welcome');
})->middleware(['auth', 'verified','nurse']);


Route::get('/Főnővér', function () {
    return view('/headNursePages/index');
})->middleware(['auth', 'verified','headNurse'])->name('/headNursePages/index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
