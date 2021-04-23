<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {
  protected $model = User::class;

  public function definition() {
    $username = Str::replaceFirst('.', '_', $this->faker->unique()->userName);
    return [
      User::username => $username,
      User::email => $username . '@' . $this->faker->freeEmailDomain,
      User::password => '$2y$10$/wW2EJXun4/7aNW/yKqp0O3/2MvBibySWPdb8KpC30FoeU/tr3ZTG', // p
      'remember_token' => Str::random(10),
    ];
  }
}
