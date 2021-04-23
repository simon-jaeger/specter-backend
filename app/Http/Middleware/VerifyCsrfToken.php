<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware {
  /**
   * The URIs that should be excluded from CSRF verification.
   *
   * @var array
   */
  protected $except = [
    //
  ];

  // skip csrf check in dev environment
  public function handle($request, Closure $next) {
    if (App::environment(['local', 'dev'])) {
      return $next($request);
    }

    return parent::handle($request, $next);
  }
}
