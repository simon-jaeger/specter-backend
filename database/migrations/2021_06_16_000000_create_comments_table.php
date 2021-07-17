<?php

use App\Models\Comment;
use App\Models\Cube;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration {
  public function up() {
    Schema::create(Comment::table(), function (Blueprint $table) {
      $table->id();
      $table->string(Comment::message);
      $table->foreignId(Cube::foreignKey())->constrained()->cascadeOnDelete();
      $table->foreignId(User::foreignKey())->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists(Comment::table());
  }
}
