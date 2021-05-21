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
  const thumbnail = 'thumbnail';
  const duration = 'duration';
  const views = 'views';

  public static function rules(string $field, Cube $existingCube = null) {
    $reqIfNew = $existingCube === null ? 'required' : 'sometimes';
    return match ($field) {
      Cube::title => [$reqIfNew, 'filled', 'string', 'max:255'],
      Cube::description => ['nullable', 'string', 'max:1000'],
      Cube::private => ['sometimes', 'boolean'],
      Cube::thumbnail => ['image', 'max:2048'],
    };
  }

  protected $guarded = [];
  protected $casts = [
    Cube::private => 'boolean',
  ];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function sides() {
    return $this->hasMany(Side::class)->orderBy(Side::position);
  }

  public function likes() {
    return $this->belongsToMany(User::class, Like::table());
  }

  public function toArray() {
    $this->thumbnail = route('cubes.thumbnail', ['cube' => $this->id]);
    return parent::toArray();
  }

  public function owned() {
    return $this->{User::foreignKey()} === Auth::id();
  }
}
