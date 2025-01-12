<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\listCommentariesController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listCommentaries',[listCommentariesController::class, 'showListCommentaries']);

Route::prefix('/createSession')->name('createSession.')->controller(\App\Http\Controllers\SeanceController::class)->group(function(){
Route::get('/', 'createSession')->name('show');
Route::post('/', 'store');
});

// Route pour la page de login
Route::get('/login-page', function () {
    return view('login-page');
});

// Route pour la page de authconstroller
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/triche', function() {
    return Hash::make("supermdp");
});
