<?php

namespace App\Http\Controllers;
use App\Models\Cube;
use App\Models\Side;
use Illuminate\Http\Request;

class SideController extends Controller {
  public function create(Request $request) {
    $data = $request->validate([
      Side::name => Side::rules(Side::name),
      Side::position => Side::rules(Side::position),
      Cube::foreignKey() => Side::rules(Cube::foreignKey()),
    ]);
    $side = Side::make($data);
    if ($side->cube->sides()->count() >= Side::_limit) return abort(422);
    $side->save();
    return $side;
  }

  public function update(Request $request, Side $side) {
    if (!$side->cube->owned()) return abort(404);
    $data = $request->validate([
      Side::name => Side::rules(Side::name, $side),
      Side::position => Side::rules(Side::position, $side),
    ]);
    $side->update($data);
    return $side;
  }

  public function destroy(Side $side) {
    if (!$side->cube->owned()) return abort(404);
    $side->delete();
    return $side;
  }
}
