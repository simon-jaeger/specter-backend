<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CubeController;
use App\Http\Controllers\CubeThumbnailController;
use App\Http\Controllers\SideController;
use App\Http\Controllers\SideVideoController;
use App\Http\Controllers\UserAvatarController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
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

  Route::get('/users/{user}/avatar', [UserAvatarController::class, 'show'])->name('users.avatar');
  Route::post('/user/avatar', [UserAvatarController::class, 'create'])->middleware('auth');
  Route::delete('/user/avatar', [UserAvatarController::class, 'destroy'])->middleware('auth');

  // cubes
  Route::get('/user/cubes', [CubeController::class, 'indexOwned'])->middleware('auth');
  Route::get('/cubes', [CubeController::class, 'index']);
  Route::post('/cubes', [CubeController::class, 'create'])->middleware('auth');

  Route::get('/cubes/{cube}', [CubeController::class, 'show']);
  Route::patch('/cubes/{cube}', [CubeController::class, 'update'])->middleware('auth');
  Route::delete('/cubes/{cube}', [CubeController::class, 'destroy'])->middleware('auth');

  Route::get('/cubes/{cube}/thumbnail', [CubeThumbnailController::class, 'show'])->name('cubes.thumbnail');
  Route::post('/cubes/{cube}/thumbnail', [CubeThumbnailController::class, 'create'])->middleware('auth');
  Route::delete('/cubes/{cube}/thumbnail', [CubeThumbnailController::class, 'destroy'])->middleware('auth');

  // sides
  Route::post('/sides', [SideController::class, 'create'])->middleware('auth');
  Route::patch('/sides/{side}', [SideController::class, 'update'])->middleware('auth');
  Route::delete('/sides/{side}', [SideController::class, 'destroy'])->middleware('auth');

  Route::get('/sides/{side}/video', [SideVideoController::class, 'show'])->name('sides.video');
  Route::post('/sides/{side}/video', [SideVideoController::class, 'create'])->middleware('auth');
  Route::delete('/sides/{side}/video', [SideVideoController::class, 'destroy'])->middleware('auth');

  // TODO: update insomnia.json
  // TODO: adjust clean up script for video files

  // TODO: flat endpoints for other resources (/comments?filter[cube_id]=42)
});
