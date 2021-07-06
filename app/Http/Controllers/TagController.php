<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Str;

class TagController extends Controller {
  public function index() {
    return QueryBuilder::for(Tag::class)
      ->allowedFilters(Tag::name)
      ->defaultSort('-id')
      ->jsonPaginate();
  }

  public function create(Request $request) {
    $data = $request->validate([
      Tag::name => Tag::rules(Tag::name),
    ]);
    $data[Tag::name] = Str::lower($data[Tag::name]);
    return Tag::create($data);
  }
}
