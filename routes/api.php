<?php

namespace App\Http\Controllers;

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

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');

Route::middleware('auth:api')->post('/post', [PostController::class, 'store']);
Route::middleware('auth:api')->get('/post', [PostController::class, 'index']);
Route::middleware('auth:api')->post('/post/{id}', [PostController::class, 'show']);
Route::middleware('auth:api')->put('/post/{id}', [PostController::class, 'update']);
Route::middleware('auth:api')->delete('/post/{id}', [PostController::class, 'destroy']);
