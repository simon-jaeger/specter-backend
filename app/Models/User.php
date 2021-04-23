<?php

namespace App\Models;
use App\Models\Traits\ModelHelpers;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rule;

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
      User::avatar => ['sometimes', 'image', 'max:1024'],
    };
  }

  protected $fillable = [self::username, self::email];
  protected $hidden = [self::password, 'remember_token'];
}
