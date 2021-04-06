<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use Modules\DisposableTools\Models\Disposable_Session;

class ActiveUsers extends Widget
{
  protected $config = ['mins' => 5];

  public function run()
  {
    $inactive_margin = time() - ($this->config['mins'] * 60);

    $activeusers = Disposable_Session::whereNotNull('user_id')
                  ->where('last_activity', '>', $inactive_margin)
                  ->select('user_id', 'last_activity')
                  ->get();

    return view('DisposableTools::active_users',['activeusers' => $activeusers]);
  }
}
