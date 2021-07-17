<?php

use App\Models\Cube;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCubeTagTable extends Migration {
  public function up() {
    Schema::create(Cube::pivotTable(Tag::class), function (Blueprint $table) {
      $table->id();
      $table->foreignId(Cube::foreignKey())->constrained()->cascadeOnDelete();
      $table->foreignId(Tag::foreignKey())->constrained()->cascadeOnDelete();
      $table->unique([Cube::foreignKey(), Tag::foreignKey()]);
    });
  }

  public function down() {
    Schema::dropIfExists(Cube::pivotTable(Tag::class));
  }
}
