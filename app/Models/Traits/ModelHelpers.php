<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait ModelHelpers {
  public static function table() {
    return self::make()->getTable();
  }

  public static function pivotTable($related) {
    return self::make()->joiningTable($related);
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

  public static function createdAt() {
    return self::table() . '.' . self::CREATED_AT;
  }

}
