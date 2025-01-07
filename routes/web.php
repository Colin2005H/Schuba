<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;

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

Route::get('/formations', [FormationController::class, 'showFormation']);
Route::post('/formations', [FormationController::class, 'createFormation']);

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/createSession')->name('createSession.')->controller(\App\Http\Controllers\SeanceController::class)->group(function(){
    Route::get('/', 'createSession')->name('show');
    Route::post('/', 'store');
});

