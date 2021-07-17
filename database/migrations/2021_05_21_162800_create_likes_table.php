<?php

use App\Models\Cube;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration {
  public function up() {
    Schema::create(Like::table(), function (Blueprint $table) {
      $table->id();
      $table->foreignId(Cube::foreignKey())->constrained()->cascadeOnDelete();
      $table->foreignId(User::foreignKey())->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists(Like::table());
  }
}
