<?php

namespace App\Models;
use App\Models\Traits\ModelHelpers;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable {
  use ModelHelpers, HasFactory;

  // fields
  const username = 'username';
  const email = 'email';
  const password = 'password';
  const avatar = 'avatar';

  public static function rules(string $field, User $existingUser = null) {
    $reqIfNew = $existingUser === null ? 'required' : 'sometimes';
    $unique = Rule::unique(User::table())->ignore($existingUser);
    return match ($field) {
      User::username => [$reqIfNew, 'alpha_dash', 'max:255', $unique],
      User::email => [$reqIfNew, 'email', $unique],
      User::password => [$reqIfNew, 'string', 'min:8'],
      User::avatar => ['mimes:jpg,png', 'max:10240'],
    };
  }

  protected $guarded = [self::password, 'remember_token'];
  protected $hidden = [self::password, 'remember_token', 'pivot'];

  public function toArray() {
    $this->avatar = '/api/users/'. $this->id . '/avatar';
    return parent::toArray();
  }

  public function cubes() {
    return $this->hasMany(Cube::class);
  }

  public function likes() {
    return $this->hasMany(Like::class)->pluck(Cube::foreignKey());
  }

  public function subscriptions() {
    return $this->belongsToMany(User::class, Subscription::table(), Subscription::subscriberKey, User::foreignKey())->withTimestamps()->orderByDesc(Subscription::createdAt());
  }

  public function subscribers() {
    return $this->belongsToMany(User::class, Subscription::table(), User::foreignKey(), Subscription::subscriberKey)->withTimestamps()->orderByDesc(Subscription::createdAt());
  }
}
