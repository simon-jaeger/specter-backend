<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class SubscriptionController extends Controller {
  public function toggle(Request $request) {
    $targetUser = User::findOrFail($request->get(User::foreignKey()));
    $targetUser->subscribers()->toggle(Auth::id());
    return Auth::user()->subscriptions()->limit(100)->get();
  }

  public function indexSubscriptions() {
    return Auth::user()->subscriptions()->paginate(100);
  }

  public function indexSubscribers() {
    return Auth::user()->subscribers()->paginate(100);
  }
}
