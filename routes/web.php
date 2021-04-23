<?php

use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


Route::prefix('api')->group(function () {
  Route::get('/ping', fn() => 'pong [' . Carbon::now()->getTimestamp() . ']');

  Route::get('/user', [UserController::class, 'me']);
  Route::patch('/user', [UserController::class, 'update']);
  Route::get('/users', [UserController::class, 'index']);
  Route::get('/users/{user}', [UserController::class, 'show']);
});
