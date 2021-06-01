<?php

namespace Database\Seeders;

use App\Models\Cube;
use App\Models\Side;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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

    Side::factory(3)->for(Cube::find(1))->state(new Sequence([Side::position => 3], [Side::position => 2], [Side::position => 1]))->create();
    Side::factory(3)->for(Cube::find(2))->state(new Sequence([Side::position => 3], [Side::position => 2], [Side::position => 1]))->create();
    Side::factory(3)->for(Cube::find(3))->state(new Sequence([Side::position => 3], [Side::position => 2], [Side::position => 1]))->create();
    Side::factory(3)->for(Cube::find(4))->state(new Sequence([Side::position => 3], [Side::position => 2], [Side::position => 1]))->create();

    collect(['sports', 'art', 'theater', 'music', 'tutorial', 'gaming', 'chess', 'culture', 'swiss', 'foo', 'bar', 'baz'])->each(function ($tag) {
      Tag::factory()->create([Tag::name => $tag]);
    });
    Cube::find(1)->tags()->attach([1, 2, 3]);
    Cube::find(2)->tags()->attach([4, 5, 6]);
    Cube::find(3)->tags()->attach([7, 8, 9]);

    User::find(1)->subscribers()->sync([2, 3, 4]);
    User::find(2)->subscribers()->sync([1, 3, 4]);
    User::find(3)->subscribers()->sync([1, 2, 4]);
  }
}
