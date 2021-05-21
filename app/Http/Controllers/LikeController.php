<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use App\Models\Like;
use Auth;
use Illuminate\Http\Request;

class LikeController extends Controller {
  public function toggle(Request $request) {
    $cube = Cube::findOrFail($request->get(Cube::foreignKey()));
    if ($cube->private) return abort(404);
    $cube->likes()->toggle(Auth::id());
    $cube->loadCount(Like::plural());
    return $cube;
  }

  public function indexUser() {
    return Auth::user()->likes();
  }
}
