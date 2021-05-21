<?php

namespace Database\Factories;

use App\Models\Cube;
use Illuminate\Database\Eloquent\Factories\Factory;

class CubeFactory extends Factory {
  protected $model = Cube::class;

  public function definition() {
    return [
      Cube::title => $this->faker->words(rand(1, 3), true),
      Cube::description => $this->faker->text,
//      Cube::private => $this->faker->boolean,
      Cube::private => false,
      Cube::views => $this->faker->numberBetween(0, 1000000),
      Cube::duration => $this->faker->numberBetween(30, 3600),
      Cube::CREATED_AT => $this->faker->dateTimeBetween('-1 year', '-6 months'),
      Cube::UPDATED_AT => $this->faker->dateTimeBetween('-6 months', '-1 day'),
    ];
  }
}
