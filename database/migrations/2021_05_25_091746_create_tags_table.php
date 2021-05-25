<?php

use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration {
  public function up() {
    Schema::create(Tag::table(), function (Blueprint $table) {
      $table->id();
      $table->string(Tag::name)->unique();
    });
  }

  public function down() {
    Schema::dropIfExists(Tag::table());
  }
}
