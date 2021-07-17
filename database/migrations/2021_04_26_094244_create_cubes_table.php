<?php

use App\Models\Cube;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCubesTable extends Migration {
  public function up() {
    Schema::create(Cube::table(), function (Blueprint $table) {
      $table->id();
      $table->string(Cube::title);
      $table->text(Cube::description)->nullable();
      $table->boolean(Cube::private)->default(1);
      $table->string(Cube::thumbnail)->nullable();
      $table->integer(Cube::duration)->unsigned()->default(0);
      $table->integer(Cube::views)->unsigned()->default(0);
      $table->foreignId(User::foreignKey())->constrained()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists(Cube::table());
  }
}
