<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {
  public function up() {
    Schema::create(User::table(), function (Blueprint $table) {
      $table->id();
      $table->string(User::username)->unique();
      $table->string(User::email)->unique();
      $table->string(User::password);
      $table->string(User::avatar)->nullable();
      $table->rememberToken();
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists(User::table());
  }
}
