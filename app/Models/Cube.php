<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCube
 */
class Cube extends Model {
  use ModelHelpers, HasFactory;

  const title = 'title';
  const description = 'description';
  const private = 'private';
  const views = 'views';
  const duration = 'duration';

  public static function rules(string $field, Cube $existingCube = null) {
    $reqIfNew = $existingCube === null ? 'required' : 'sometimes';
    return match ($field) {
      Cube::title => [$reqIfNew, 'filled', 'string', 'max:255'],
      Cube::description => ['nullable', 'string', 'max:1000'],
      Cube::private => ['sometimes', 'boolean'],
    };
  }

  protected $guarded = [];
  protected $casts = [
    Cube::private => 'boolean',
  ];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function owned() {
    return $this->{User::foreignKey()} === Auth::id();
  }
}
