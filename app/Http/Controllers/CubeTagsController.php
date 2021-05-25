<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use App\Models\Tag;
use Str;

class CubeTagsController extends Controller {
  public function create(Cube $cube, $tags) {
    if (!$cube->owned()) return abort(404);
    $tags = Str::of($tags)->explode(',');
    if ($tags->count() > Tag::_limit) return abort(422);
    $cube->tags()->sync($tags);
    $cube->load(Tag::plural());
    return $cube;
  }
}
