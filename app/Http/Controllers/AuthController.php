<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller {
  public function register(Request $request) {
    $data = $request->validate([
      User::username => User::rules(User::username),
      User::email => User::rules(User::email),
      User::password => User::rules(User::password),
    ]);
    $user = User::create($data);
    $user->password = Hash::make($user->password);
    Auth::login($user, true);
    return $user;
  }

  public function login(Request $request) {
    if (Auth::attempt([User::email => $request->get(User::email), User::password => $request->get(User::password)], true)) {
      Session::regenerate();
      return Auth::user();
    }
    throw ValidationException::withMessages([
      User::email => __('auth.failed'),
    ]);
  }

  public function logout() {
    Auth::logout();
    Session::invalidate();
    Session::regenerateToken();
    return 'ok';
  }
}
