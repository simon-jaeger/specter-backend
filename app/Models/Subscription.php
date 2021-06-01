<?php

namespace App\Models;

use App\Models\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSubscription
 */
class Subscription extends Model {
  use ModelHelpers;

  const subscribers = 'subscribers';
  const subscriberKey = 'subscriber_id';

  protected $guarded = [];
}
