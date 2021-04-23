<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  public function run() {
    User::factory()->create([
      User::username => 'a',
      User::email => 'a@m',
    ]);
    User::factory(11)->create();
  }
}
