<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use Auth;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class ViewController extends Controller {
  public function create(Request $request) {
    $cube = Cube::findOrFail($request->get(Cube::foreignKey()));
    if ($cube->private) return abort(404);

    $rateId = Auth::id() . '|' . $cube->id;
    $rateLimit = 1;
    $rateCooldown = CarbonInterval::day()->totalSeconds;
    if (RateLimiter::tooManyAttempts($rateId, $rateLimit)) {
      return abort(429, 'cooldown: ' . RateLimiter::availableIn($rateId) . ' seconds');
    }
    RateLimiter::hit($rateId, $rateCooldown);

    $cube->views++;
    $cube->save();
    return $cube;
  }
}
