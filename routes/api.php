<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('teams')->group(function () {
    Route::get('/{id}', [TeamController::class, 'index']);
    Route::get('/show/{id}', [TeamController::class, 'show']);
    Route::post('/', [TeamController::class, 'store']);
    Route::post('/add-user/{id}', [TeamController::class, 'addTeamUser']);
    Route::post('/remove-user/{id}', [TeamController::class, 'removeTeamUser']);
    Route::put('/{id}', [TeamController::class, 'update']);
    Route::delete('/{id}', [TeamController::class, 'destroy']);
});

Route::prefix('/tags')->group(function() {
    Route::get('/{id}', [TagController::class, 'index']);
    Route::get('/show/{id}', [TagController::class, 'show']);
    Route::post('/', [TagController::class, 'store']);
    Route::put('/{id}', [TagController::class, 'update']);
    Route::delete('/{id}', [TagController::class, 'destroy']);
});

Route::prefix('/logs')->group(function() {
    Route::get('/{id}', [LogController::class, 'index']);
    Route::get('/show/{id}', [LogController::class, 'show']);
    Route::post('/', [LogController::class, 'store']);
    Route::put('/{id}', [LogController::class, 'update']);
    Route::delete('/{id}', [LogController::class, 'destroy']);
});

Route::prefix('/comments')->group(function() {
    Route::get('/{id}', [CommentController::class, 'index']);
    Route::get('/show/{id}', [CommentController::class, 'show']);
    Route::post('/', [CommentController::class, 'store']);
    Route::put('/{id}', [CommentController::class, 'update']);
    Route::delete('/{id}', [CommentController::class, 'destroy']);
});

Route::prefix('/checklists')->group(function() {
    Route::get('/{id}', [CheckListController::class, 'index']);
    Route::get('/show/{id}', [CheckListController::class, 'show']);
    Route::post('/', [CheckListController::class, 'store']);
    Route::put('/{id}', [CheckListController::class, 'update']);
    Route::delete('/{id}', [CheckListController::class, 'destroy']);
});

Route::prefix('/cards')->group(function() {
    Route::get('/{id}', [CardController::class, 'index']);
    Route::get('/show/{id}', [CardController::class, 'show']);
    Route::post('/', [CardController::class, 'store']);
    Route::put('/{id}', [CardController::class, 'update']);
    Route::delete('/{id}', [CardController::class, 'destroy']);
});

Route::prefix('tasks')->group(function () {
    Route::get('/{id}', [TaskController::class, 'index']);
    Route::get('/show/{id}', [TaskController::class, 'show']);
    Route::post('/', [TaskController::class, 'store']);
    Route::post('/add-user/{id}', [TaskController::class, 'assignUser']);
    Route::post('/remove-user/{id}', [TaskController::class, 'deallocateUser']);
    Route::put('/{id}', [TaskController::class, 'update']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
});
