<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * @mixin IdeHelperComment
 */
class Comment extends Model {
  use HasFactory, modelHelpers;

  const message = 'message';

  public static function rules(string $field) {
    return match ($field) {
      Comment::message => ['required', 'string', 'max:255'],
    };
  }

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function cube() {
    return $this->belongsTo(Cube::class);
  }

  protected $guarded = [];
}
