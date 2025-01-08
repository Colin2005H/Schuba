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

Route::get('/training', [PloFormationController::class, "liste"]);

Route::get('/aptitude', [PloAptitudeController::class, "liste"]);

Route::get('/club', [PloClubController::class, "liste"]);

Route::get('/competence', [PloCompetenceController::class, "liste"]);

Route::get('/location', [PloLieuController::class, "liste"]);

Route::get('/session', [PloSeanceController::class, "get"]);
Route::post('/session', [PloSeanceController::class, "create"]);
Route::put('/session/{id}', [PloSeanceController::class, "update"]);
Route::delete('/session/{id}', [PloSeanceController::class, "delete"]);

Route::get('/user', [PloUtilisateurController::class, "liste"]);
Route::get('/user/student', [PloUtilisateurController::class, "eleve"]);
Route::get('/user/instructor', [PloUtilisateurController::class, "initiateur"]);

Route::get('/leader', [DirigerLeClubController::class, "liste"]);

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
