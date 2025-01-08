<?php

use App\Http\Controllers\Api\AppartientController;
use App\Http\Controllers\Api\DirigerLeClubController;
use App\Http\Controllers\Api\EnseignerController;
use App\Http\Controllers\Api\GererLaFormationController;
use App\Http\Controllers\Api\GrouperController;
use App\Http\Controllers\Api\PloAptitudeController;
use App\Http\Controllers\Api\PloClubController;
use App\Http\Controllers\Api\PloCompetenceController;
use App\Http\Controllers\Api\PloEleveController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PloFormationController;
use App\Http\Controllers\Api\PloInitiateurController;
use App\Http\Controllers\Api\PloLieuController;
use App\Http\Controllers\Api\PloSeanceController;
use App\Http\Controllers\Api\PloUtilisateurController;
use App\Http\Controllers\Api\ValiderController;

Route::get('/location', [PloLieuController::class, "get"]);
Route::post('/location', [PloLieuController::class, "create"]);
Route::put('/location/{id}', [PloLieuController::class, "update"]);
Route::delete('/location/{id}', [PloLieuController::class, "delete"]);

Route::get('/session', [PloSeanceController::class, "get"]);
Route::post('/session', [PloSeanceController::class, "create"]);
Route::put('/session/{id}', [PloSeanceController::class, "update"]);
Route::delete('/session/{id}', [PloSeanceController::class, "delete"]);

Route::get('/user', [PloUtilisateurController::class, "get"]);
Route::post('/user', [PloUtilisateurController::class, "create"]);
Route::put('/user/{id}', [PloUtilisateurController::class, "update"]);
Route::delete('/user/{id}', [PloUtilisateurController::class, "delete"]);

Route::get('/initiator', [PloInitiateurController::class, "get"]);
Route::post('/initiator', [PloInitiateurController::class, "create"]);
Route::put('/initiator/{id}', [PloInitiateurController::class, "update"]);
Route::delete('/initiator/{id}', [PloInitiateurController::class, "delete"]);

Route::get('/formation', [PloFormationController::class, "get"]);
Route::post('/formation', [PloFormationController::class, "create"]);
Route::put('/formation/{id}', [PloFormationController::class, "update"]);
Route::delete('/formation/{id}', [PloFormationController::class, "delete"]);

Route::get('/skill', [PloCompetenceController::class, "get"]);
Route::post('/skill', [PloUtilisateurController::class, "create"]);
Route::put('/skill/{id}', [PloUtilisateurController::class, "update"]);
Route::delete('/skill/{id}', [PloUtilisateurController::class, "delete"]);

Route::get('/club', [PloClubController::class, "get"]);
Route::post('/club', [PloClubController::class, "create"]);
Route::put('/club/{id}', [PloClubController::class, "update"]);
Route::delete('/club/{id}', [PloClubController::class, "delete"]);

Route::get('/aptitude', [PloAptitudeController::class, "get"]);
Route::post('/aptitude', [PloAptitudeController::class, "create"]);
Route::put('/aptitude/{id}', [PloAptitudeController::class, "update"]);
Route::delete('/aptitude/{id}', [PloAptitudeController::class, "delete"]);

Route::get('/leader', [DirigerLeClubController::class, "get"]);
Route::post('/leader', [DirigerLeClubController::class, "create"]);
Route::delete('/leader/{id}', [DirigerLeClubController::class, "delete"]);

Route::get('/student', [PloEleveController::class, "get"]);
Route::post('/student', [PloEleveController::class, "create"]);
Route::delete('/student/{id}', [PloEleveController::class, "delete"]);

Route::get('/group', [GrouperController::class, "get"]);
Route::post('/group', [GrouperController::class, "create"]);
Route::delete('/group/{id}', [GrouperController::class, "delete"]);

Route::get('/teaching', [EnseignerController::class, "get"]);
Route::post('/teaching', [EnseignerController::class, "create"]);
Route::delete('/teaching/{id}', [EnseignerController::class, "delete"]);

Route::get('/validate', [ValiderController::class, "get"]);
Route::post('/validate', [ValiderController::class, "create"]);
Route::put('/validate/{id}', [ValiderController::class, "update"]);
Route::delete('/validate/{id}', [ValiderController::class, "delete"]);

Route::get('/manager', [GererLaFormationController::class, "get"]);
Route::post('/manager', [GererLaFormationController::class, "create"]);
Route::delete('/manager/{id}', [GererLaFormationController::class, "delete"]);

Route::get('/signed', [AppartientController::class, "get"]);
Route::post('/signed', [AppartientController::class, "create"]);
Route::delete('/signed/{id}', [AppartientController::class, "delete"]);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
