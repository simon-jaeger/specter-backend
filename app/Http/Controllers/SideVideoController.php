<?php

namespace App\Http\Controllers;
use App\Models\Side;
use Illuminate\Http\Request;
use Storage;

class SideVideoController extends Controller {
  public function show(Side $side) {
    $cube = $side->cube;
    if ($cube->private && !$cube->owned()) return abort(404);
    if ($side->video === null) return abort(404);
    return Storage::response($side->video);
  }

  public function create(Request $request, Side $side) {
    $cube = $side->cube;
    if (!$cube->owned()) return abort(404);
    $request->validate([
      Side::video => Side::rules(Side::video)
    ]);
    $side->video = Storage::putFile('', $request->file(Side::video));
    $side->save();
    return Storage::response($side->video);
  }

  public function destroy(Side $side) {
    $cube = $side->cube;
    if (!$cube->owned()) return abort(404);
    $side->video = null;
    $side->save();
    return 'ok';
  }
}
