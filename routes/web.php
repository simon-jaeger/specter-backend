<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware('throttle:90,1')->group(function () {
  // meta
  Route::get('/ping', fn() => 'pong [' . Carbon::now()->getTimestamp() . ']');

  // auth
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

  // users
  Route::get('/user', [UserController::class, 'me'])->middleware('auth');
  Route::patch('/user', [UserController::class, 'update'])->middleware('auth');
  Route::get('/users', [UserController::class, 'index']);
  Route::get('/users/{user}', [UserController::class, 'show']);
});
