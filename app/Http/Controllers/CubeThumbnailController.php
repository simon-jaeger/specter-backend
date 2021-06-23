<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Storage;

class CubeThumbnailController extends Controller {
  const fallback = 'thumbnail.svg';
  const sizes = [
    'lg' => ['lg_', 1920, 1080],
    'md' => ['md_', 960, 540],
    'sm' => ['sm_', 480, 270],
  ];

  public function show(Request $request, Cube $cube) {
    $size = self::sizes[$request->query('size')] ?? self::sizes['lg'];
    if ($cube->private && !$cube->owned()) return abort(404);
    if (!$cube->thumbnail) return Storage::response(self::fallback);
    return Storage::response($size[0] . $cube->thumbnail);
  }

  public function create(Request $request, Cube $cube) {
    if (!$cube->owned()) return abort(404);
    $request->validate([
      Cube::thumbnail => Cube::rules(Cube::thumbnail, $cube),
    ]);
    $filename = $request->file(Cube::thumbnail)->hashName();
    $img = Image::make($request->file(Cube::thumbnail));
    collect(self::sizes)->each(function ($size) use ($filename, $img) {
      Storage::put($size[0] . $filename, $img->fit($size[1], $size[2])->encode());
    });
    $cube->thumbnail = $filename;
    $cube->save();
    return Storage::response(self::sizes['lg'][0] . $cube->thumbnail);
  }

  public function destroy(Cube $cube) {
    if (!$cube->owned()) return abort(404);
    $cube->thumbnail = null;
    $cube->save();
    return Storage::response(self::fallback);
  }
}
