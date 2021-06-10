<?php

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration {
  public function up() {
    Schema::create(Subscription::table(), function (Blueprint $table) {
      $table->id();
      $table->foreignId(Subscription::subscriberKey)->constrained(User::table());
      $table->foreignId(User::foreignKey())->constrained();
      $table->timestamps();
    });
  }

  public function down() {
    Schema::dropIfExists(Subscription::table());
  }
}
