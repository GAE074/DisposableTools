<?php

namespace Modules\DisposableTools\Models;

use App\Contracts\Model;
use App\Models\User;

class Disposable_Session extends Model
{
  public $table = 'sessions';

  /* Relationship To User */
  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
