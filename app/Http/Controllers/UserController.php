<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Storage;

class UserController extends Controller {
  public function me() {
    return Auth::user();
  }

  public function show(User $user) {
    return $user;
  }

  public function index() {
    return QueryBuilder::for(User::class)
      ->allowedFilters(
        AllowedFilter::exact('id'),
        User::username,
        User::email,
      )
      ->allowedSorts(
        User::username,
        User::email,
        User::CREATED_AT,
        User::UPDATED_AT,
      )
      ->paginate(100)->appends(request()->query());
  }

  public function update(Request $request) {
    $user = Auth::user();
    $data = $request->validate([
      User::username => User::rules(User::username, $user),
      User::email => User::rules(User::email, $user),
      User::password => User::rules(User::password, $user),
    ]);
    $user->fill($data);
    if ($request->has(User::password))
      $user->password = Hash::make($request->get(User::password));
    $user->save();
    return $user;
  }
}
