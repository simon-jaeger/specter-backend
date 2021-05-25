<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * @mixin IdeHelperTag
 */
class Tag extends Model {
  use HasFactory, modelHelpers;

  const name = 'name';

  public static function rules(string $field) {
    return match ($field) {
      Tag::name => ['required', 'alpha_dash', 'min:2', 'max:24', 'unique:' . Tag::table(), Rule::notIn(['violence', 'crime', 'other-bad-words-here'])],
    };
  }

  public function cubes() {
    return $this->belongsToMany(Cube::class);
  }

  public $timestamps = false;
  protected $guarded = [];
  protected $hidden = ['pivot'];
}
