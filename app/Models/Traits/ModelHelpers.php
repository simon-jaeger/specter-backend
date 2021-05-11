<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait ModelHelpers {
  public static function table() {
    return self::make()->getTable();
  }

  public static function foreignKey() {
    return self::make()->getForeignKey();
  }

  public static function singular() {
    return Str::snake(class_basename(self::make()));
  }

  public static function plural() {
    return Str::plural(self::singular());
  }

  public static function count() {
    return self::plural() . '_count';
  }
}
