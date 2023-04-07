<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Entities\ContinentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/created', [AuthController::class, 'usersCreated']);
Route::get('/users/verified/{guid}', [AuthController::class, 'usersVerified']);

//Route::middleware('auth:sanctum')->get('/continents', [ContinentsController::class, 'all']);//->middleware('auth.token');



Route::middleware(['auth:sanctum'])->group(function () {
    Route::delete('/users/delete', [AuthController::class, 'userDelete']);

    Route::post('/projects', [\App\Http\Controllers\Entities\ProjectsController::class, 'create']);
    Route::post('/projects/link ', [\App\Http\Controllers\Entities\ProjectsController::class, 'link']);
    Route::delete('/projects ', [\App\Http\Controllers\Entities\ProjectsController::class, 'destroy']);

    Route::post('/labels ', [\App\Http\Controllers\Entities\LabelsController::class, 'create']);
    Route::post('/labels/link ', [\App\Http\Controllers\Entities\LabelsController::class, 'link']);
    Route::delete('/labels ', [\App\Http\Controllers\Entities\LabelsController::class, 'destroy']);

    Route::get('/continents', [ContinentsController::class, 'all']);
});

Route::get('/projects ', [\App\Http\Controllers\Entities\ProjectsController::class, 'list']);
Route::get('/users', [AuthController::class, 'all']);
