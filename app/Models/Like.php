<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperLike
 */
class Like extends Model {
  use ModelHelpers;

  protected $guarded = [];
}
