<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Cube;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory {
  protected $model = Comment::class;

  public function definition() {
    return [
      Comment::message => $this->faker->unique()->text(255),
      User::foreignKey() => $this->faker->numberBetween(1, 4),
      Cube::foreignKey() => $this->faker->numberBetween(1, 4),
    ];
  }
}
