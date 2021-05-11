<?php

use App\Models\Cube;
use App\Models\Side;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSidesTable extends Migration {
  public function up() {
    Schema::create(Side::table(), function (Blueprint $table) {
      $table->id();
      $table->string(Side::name);
      $table->enum(Side::position, range(1, Side::_limit));
      $table->string(Side::video)->nullable();
      $table->foreignId(Cube::foreignKey())->constrained();
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists(Side::table());
  }
}
