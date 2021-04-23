<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


Route::prefix('api')->group(function () {
  Route::get('/ping', fn() => 'pong [' . Carbon::now()->getTimestamp() . ']');
});
