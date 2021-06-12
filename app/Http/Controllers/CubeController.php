<?php

namespace App\Http\Controllers;

use App\Models\Cube;
use App\Models\Like;
use App\Models\Side;
use App\Models\Tag;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CubeController extends Controller {
  public function indexUser() {
    return QueryBuilder::for(Auth::user()->cubes())
      ->withCount(Like::plural())
      ->with(Tag::plural())
      ->allowedFilters(
        Cube::title,
        Cube::private,
      )
      ->allowedSorts(
        Cube::title,
        Cube::duration,
        Cube::views,
        Like::count(),
        Cube::CREATED_AT,
        Cube::UPDATED_AT,
      )
      ->paginate(100)->appends(request()->query());
  }

  public function index() {
    return QueryBuilder::for(Cube::class)
      ->where(Cube::private, false)
      ->with(User::singular())
      ->withCount(Like::plural())
      ->with(Tag::plural())
      ->allowedFilters(
        Cube::title,
        AllowedFilter::exact(User::foreignKey()),
        AllowedFilter::exact(Tag::plural() . '.' . Tag::name),
      )
      ->allowedSorts(
        Cube::duration,
        Cube::views,
        Like::count(),
        Cube::CREATED_AT,
        Cube::UPDATED_AT,
      )
      ->paginate(100)->appends(request()->query());
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
    $cube->load([Side::plural(), Tag::plural()]);
    $cube->loadCount(Like::plural());
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
