<?php

use App\Http\Controllers\CreateAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\listCommentariesController;
use App\Http\Controllers\AptitudesTableStudentController;
use App\Http\Controllers\AptitudesGlobalTableController;
use App\Http\Controllers\ValidationCompetencesController;

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

Route::get('/header', function() {
    return view('header');
});

Route::get('/home', function() {
    return view('home');
});

Route::get('/triche', function() {
    return Hash::make("responsable");
});

Route::get('/calendar', function () {
    return view('calendar');
});

Route::prefix('/aptitudes/{userId}')->name('aptitudes.')->controller(AptitudesTableStudentController::class)->group(function(){
    Route::get('/', 'showListAptitudes')->name('show');
});

Route::prefix('/globalAptitudes/{level}')->name('globalAptitudes.')->controller(AptitudesGlobalTableController::class)->group(function(){
    Route::get('/', 'showListAptitudes')->name('show');
});

Route::get('/footer', function () {
    return view('footer');
});


Route::prefix('/validationcomp/{userId}')->name('validationcomp.')->controller(ValidationCompetencesController::class)->group(function(){
    Route::get('/', 'showCompetences')->name('show');
    Route::post('/', 'valideCompetences')->name('valider');
});
