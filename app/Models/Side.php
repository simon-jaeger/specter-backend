<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * @mixin IdeHelperSide
 */
class Side extends Model {
  use ModelHelpers, HasFactory;

  const name = 'name';
  const position = 'position';
  const video = 'video';

  const _limit = 6;

  public static function rules(string $field, Side $existingSide = null) {
    $reqIfNew = $existingSide === null ? 'required' : 'sometimes';
    return match ($field) {
      Side::name => [$reqIfNew, 'string', 'max:64'],
      Side::position => [$reqIfNew, Rule::in(range(1, self::_limit))],
      Cube::foreignKey() => ['required', Rule::exists(Cube::plural(), 'id')->where(fn($query) => $query->where(User::foreignKey(), Auth::id()))],
    };
  }

  protected $guarded = [];
  protected $casts = [
    Side::position => 'integer',
  ];

  public function cube() {
    return $this->belongsTo(Cube::class);
  }
}
