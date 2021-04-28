<?php

namespace Database\Seeders;

use App\Models\Cube;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  public function run() {
    User::factory()->create([
      User::username => 'a',
      User::email => 'a@m',
    ]);
    User::factory(11)->create();

    Cube::factory(3)->for(User::find(1))->create();
    Cube::factory(3)->for(User::find(2))->create();
    Cube::factory(3)->for(User::find(3))->create();
    Cube::factory(3)->for(User::find(4))->create();
  }
}
