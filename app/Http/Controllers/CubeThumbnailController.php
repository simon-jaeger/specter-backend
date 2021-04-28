<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use Illuminate\Http\Request;
use Storage;

class CubeThumbnailController extends Controller {
  const fallback = 'thumbnail.svg';

  public function show(Cube $cube) {
    if ($cube->private && !$cube->owned()) return abort(404);
    return Storage::response($cube->thumbnail ?? self::fallback);
  }

  public function create(Request $request, Cube $cube) {
    if (!$cube->owned()) return abort(404);
    $request->validate([
      Cube::thumbnail => Cube::rules(Cube::thumbnail, $cube),
    ]);
    $cube->thumbnail = Storage::putFile('', $request->file(Cube::thumbnail));
    $cube->save();
    return Storage::response($cube->thumbnail);
  }

  public function destroy(Cube $cube) {
    if (!$cube->owned()) return abort(404);
    $cube->thumbnail = null;
    $cube->save();
    return Storage::response(self::fallback);
  }
}
