<?php

namespace Database\Factories;

use App\Models\Side;
use Illuminate\Database\Eloquent\Factories\Factory;

class SideFactory extends Factory {
  protected $model = Side::class;

  public function definition() {
    return [
      Side::name => $this->faker->words(rand(1, 2), true),
      Side::video => null,
      Side::position => $this->faker->numberBetween(1, 6),
    ];
  }
}
