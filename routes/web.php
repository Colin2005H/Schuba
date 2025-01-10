<?php


use App\Http\Controllers\ValidationCompetencesController;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\listUserController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\MemberListController;
use App\Http\Controllers\BilanSeanceController;
use App\Http\Controllers\ModifSeanceController;

use App\Http\Controllers\CreateAccountController;
use App\Http\Controllers\ModifierCompteController;
use App\Http\Controllers\listCommentariesController;
use App\Http\Controllers\AptitudesGlobalTableController;
use App\Http\Controllers\AptitudesTableStudentController;

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

Route::get('/liste-membres-formation', [MemberListController::class, 'showList']);

Route::get('/', function () {
    return view('login-page');
});


Route::get('/listUser',[listUserController::class, 'showListUser']);
Route::get('/modifierCompte/{id}', [ModifierCompteController::class, 'edit'])->name('modifierCompte');
Route::post('/modifierCompte/{id}', [ModifierCompteController::class, 'update'])->name('modifierCompte');




Route::prefix('/profile')->name('profile.')->controller(ProfileController::class)->group(function(){
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

Route::post('/showForm', [BilanSeanceController::class, 'showForm'])->name('seance-store');

Route::get('/triche', function() {
    return Hash::make("responsable");
    return Hash::make("admin");
});


Route::prefix('/changeData')->name('changeData.')->controller(\App\Http\Controllers\ChangeDataController::class)->group(function(){
    Route::get('/showEmail', 'showEmail')->name('showEmail');
    Route::get('/showPassword', 'showPassword')->name('showPassword');
    Route::post('/showEmail', 'editEmail');
    Route::post('/showPassword', 'editPassword');
});


Route::post('/seance-store', [BilanSeanceController::class, 'store'])->name('seance-store2');

Route::prefix('/calendar')->name('calendar.')->controller(\App\Http\Controllers\CalendarController::class)->group(function(){
    Route::get('/', 'show')->name('show');
    Route::get('/{sessionId}', 'tableSession')->name('tableSession');
    Route::post('/', 'store');

});

//Routes pour la page pour enregistrer les aptitudes à travailler dans une seance
Route::get('/setWorkedSkills/{id}', [App\Http\Controllers\workedSkillsController::class, "index"])->name('setWorkedSkills');

Route::post('/setWorkedSkills/{id}', [App\Http\Controllers\workedSkillsController::class, "store"]);
Route::prefix('/aptitudes/{userId}')->name('aptitudes.')->controller(AptitudesTableStudentController::class)->group(function(){
    Route::get('/', 'showListAptitudes')->name('show');
});

Route::prefix('/globalAptitudes/{level}')->name('globalAptitudes.')->controller(AptitudesGlobalTableController::class)->group(function(){
    Route::get('/', 'showListAptitudes')->name('show');
});

Route::get('/footer', function () {
    return view('footer');
});
Route::get('/seance/{seance_id}/bilan', [BilanSeanceController::class, 'showForm'])->name('bilan.showForm');

Route::get('/create-csv', [CsvController::class, 'createCsvUser']);

Route::get('/listUser',[listUserController::class, 'showListUser'])->name('listUser');
Route::post('/listUser',[listUserController::class, 'deleteUser'])->name('listUser2');

Route::get('/modifierCompte/{id}', [ModifierCompteController::class, 'edit'])->name('modifierCompte');
Route::post('/modifierCompte/{id}', [ModifierCompteController::class, 'update'])->name('modifierCompte2');

Route::post('/seance/{seance_id}/update', [ModifSeanceController::class, 'update'])->name('seance-update');

Route::get('/seance/{seance_id}/modif', [ModifSeanceController::class, 'showForm'])->name('bilan.modif');

Route::get('/seance/{seance_id}/delete', [ModifSeanceController::class, 'delete'])->name('seance.delete');

Route::prefix('/aptitudes/{userId}')->name('aptitudes.')->controller(AptitudesTableStudentController::class)->group(function(){
    Route::get('/', 'showListAptitudes')->name('show');
});

Route::prefix('/validationcomp/{userId}')->name('validationcomp.')->controller(ValidationCompetencesController::class)->group(function(){
    Route::get('/', 'showCompetences')->name('show');
    Route::post('/', 'valideCompetences')->name('valider');
});
