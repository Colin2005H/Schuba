<?php

use App\Http\Controllers\Api\PloClubController;
use App\Http\Controllers\Api\PloCompetenceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PloFormationController;
use App\Http\Controllers\Api\PloInitiateurController;
use App\Http\Controllers\Api\PloLieuController;
use App\Http\Controllers\Api\PloSeanceController;
use App\Http\Controllers\Api\PloUtilisateurController;

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
