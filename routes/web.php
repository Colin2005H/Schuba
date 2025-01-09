<?php

use App\Http\Controllers\CreateAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BilanSeanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\listCommentariesController;
use App\Http\Controllers\ModifSeanceController;


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
Route::get('/formations', [FormationController::class, 'showFormation']);
Route::post('/formations', [FormationController::class, 'createFormation']);

Route::get('/', function () {
    return view('login-page');
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

Route::get('/recapitulatif', [BilanSeanceController::class, 'showForm']);

Route::get('/recapitulatif2', [BilanSeanceController::class, 'showFormTest']);

Route::get('/header', function() {
    return view('header');
});



Route::post('/showForm', [BilanSeanceController::class, 'showForm'])->name('seance-store-show');

Route::get('/home', function() {
    return view('home');
});

Route::get('/triche', function() {
    return Hash::make("responsable");
    return Hash::make("admin");
});


Route::post('/seance-store', [BilanSeanceController::class, 'store'])->name('seance-store');


Route::prefix('/calendar')->name('calendar.')->controller(\App\Http\Controllers\CalendarController::class)->group(function(){
    Route::get('/', 'show')->name('show');
    Route::get('/{sessionId}', 'tableSession')->name('tableSession');
    Route::post('/', 'store');

});

Route::get('/footer', function () {
    return view('footer');
});

Route::get('/seance/{seance_id}/bilan', [BilanSeanceController::class, 'showForm'])->name('bilan.showForm');

Route::post('/seance/{seance_id}/update', [ModifSeanceController::class, 'update'])->name('seance-update');

Route::get('/seance/{seance_id}/modif', [ModifSeanceController::class, 'showForm'])->name('bilan.modif');

Route::get('/seance/{seance_id}/delete', [ModifSeanceController::class, 'delete'])->name('seance.delete');
