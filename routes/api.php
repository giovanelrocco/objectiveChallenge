<?php

use App\Http\Controllers\ContasController;
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

Route::get('/contas', [ContasController::class, 'index']);
Route::get('/conta', [ContasController::class, 'index']);
Route::get('/conta/{id}', [ContasController::class, 'show']);
Route::put('/conta', [ContasController::class, 'store']);
Route::patch('/conta/{id}', [ContasController::class, 'update']);
