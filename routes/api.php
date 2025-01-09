<?php

use App\Http\Controllers\Api\DirigerLeClubController;
use App\Http\Controllers\Api\PloAptitudeController;
use App\Http\Controllers\Api\PloClubController;
use App\Http\Controllers\Api\PloCompetenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PloEleveController;
use App\Http\Controllers\Api\PloFormationController;
use App\Http\Controllers\Api\PloInitiateurController;
use App\Http\Controllers\Api\PloLieuController;
use App\Http\Controllers\Api\PloSeanceController;
use App\Http\Controllers\Api\PloUtilisateurController;
use App\Models\PloInitiateur;

Route::get('/eleve', [PloEleveController::class, "liste"]);
Route::get('/eleve/{id}', [PloEleveController::class, "detail"]);

Route::get('/formation', [PloFormationController::class, "liste"]);
Route::get('/formation/{id}', [PloFormationController::class, "detail"]);

Route::get('/aptitude', [PloAptitudeController::class, "liste"]);
Route::get('/aptitude/{id}', [PloAptitudeController::class, "detail"]);

Route::get('/club', [PloClubController::class, "liste"]);
Route::get('/club/{id}', [PloClubController::class, "detail"]);

Route::get('/competence', [PloCompetenceController::class, "liste"]);
Route::get('/competence/{id}', [PloCompetenceController::class, "detail"]);

Route::get('/initiateur', [PloInitiateurController::class, "liste"]);
Route::get('/initiateur/{id}', [PloInitiateurController::class, "detail"]);

Route::get('/lieu', [PloLieuController::class, "liste"]);
Route::get('/lieu/{id}', [PloLieuController::class, "detail"]);

Route::get('/seance', [PloSeanceController::class, "liste"]);

Route::get('/utilisateur', [PloUtilisateurController::class, "liste"]);
Route::get('/utilisateur/{id}', [PloUtilisateurController::class, "detail"]);

Route::get('/dirigeant', [DirigerLeClubController::class, "liste"]);
Route::get('/dirigeant/{id}', [DirigerLeClubController::class, "detail"]);

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
