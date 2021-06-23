<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Storage;

class UserAvatarController extends Controller {
  const fallback = 'avatar.svg';

  public function show(User $user) {
    return Storage::response($user->avatar ?? self::fallback);
  }

  public function create(Request $request) {
    $request->validate([
      User::avatar => User::rules(User::avatar),
    ]);
    $user = Auth::user();
    $filename = $request->file(User::avatar)->hashName();
    $img = Image::make($request->file(User::avatar))
      ->fit(200, 200)
      ->encode();
    Storage::put($filename, $img);
    $user->avatar = $filename;
    $user->save();
    return Storage::response($user->avatar);
  }

  public function destroy() {
    $user = Auth::user();
    $user->avatar = null;
    $user->save();
    return Storage::response(self::fallback);
  }
}
