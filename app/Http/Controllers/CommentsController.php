<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Cube;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class CommentsController extends Controller {
  public function index(Request $request) {
    $cube = Cube::findOrFail($request->input('filter.' . Cube::foreignKey()));
    if ($cube->private) return abort(404);
    return $cube->comments()->with(User::singular())->latest()->jsonPaginate();
  }

  public function create(Request $request) {
    $request->validate([Comment::message => Comment::rules(Comment::message)]);
    $cube = Cube::findOrFail($request->get(Cube::foreignKey()));
    if ($cube->private) return abort(404);
    return Comment::create([
      Comment::message => $request->get(Comment::message),
      Cube::foreignKey() => $cube->id,
      User::foreignKey() => Auth::id(),
    ]);
  }
}
