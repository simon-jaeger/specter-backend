<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends Controller {
  public function index() {
    return QueryBuilder::for(Tag::class)
      ->allowedFilters(Tag::name)
      ->paginate(100)->appends(request()->query());
  }

  public function create(Request $request) {
    $data = $request->validate([
      Tag::name => Tag::rules(Tag::name),
    ]);
    return Tag::create($data);
  }
}
