<?php

use App\Http\Controllers\CreateAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
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

//Route pour la page d'accueil
Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/profile')->name('profile.')->controller(\App\Http\Controllers\ProfileController::class)->group(function(){
    Route::get('/', 'index')->name('show');
});

//Route pour la page de création de compte
Route::prefix('/createAccount')->name('createAccount.')->controller(CreateAccountController::class)->group(function(){
    Route::get('/', 'createAccount')->name('show');
    Route::post('/', 'store');
});

//Route pour la page de création de session
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
