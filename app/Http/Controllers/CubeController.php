<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CubeController extends Controller {
  public function indexOwned() {
    return QueryBuilder::for(Auth::user()->cubes())
      ->allowedFilters(
        Cube::title,
        Cube::private,
      )
      ->allowedSorts(
        Cube::title,
        Cube::views,
        Cube::duration,
        Cube::CREATED_AT,
        Cube::UPDATED_AT,
      )->get();
  }

  public function index() {
    return QueryBuilder::for(Cube::class)
      ->where(Cube::private, false)
      ->with(User::singular())
      ->allowedFilters(
        Cube::title,
        AllowedFilter::exact(User::foreignKey())
      )
      ->allowedSorts(
        Cube::views,
        Cube::duration,
        Cube::CREATED_AT,
        Cube::UPDATED_AT,
      )
      ->get();
  }

  public function create(Request $request) {
    $data = $request->validate([
      Cube::title => Cube::rules(Cube::title),
    ]);
    $cube = Auth::user()->cubes()->create($data);
    $cube->refresh();
    return $cube;
  }

  public function show(Cube $cube) {
    if ($cube->private && !$cube->owned()) return abort(404);
    return $cube;
  }

  public function update(Request $request, Cube $cube) {
    if (!$cube->owned()) return abort(404);;
    $data = $request->validate([
      Cube::title => Cube::rules(Cube::title, $cube),
      Cube::description => Cube::rules(Cube::description, $cube),
      Cube::private => Cube::rules(Cube::private, $cube),
    ]);
    $cube->update($data);
    return $cube;
  }

  public function destroy(Cube $cube) {
    if (!$cube->owned()) return abort(404);;
    $cube->delete();
    return $cube;
  }
}