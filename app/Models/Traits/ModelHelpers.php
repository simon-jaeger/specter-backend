<?php

namespace App\Models\Traits;

trait ModelHelpers {
  public static function table() {
    return self::make()->getTable();
  }
}
