<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;

class FlightTimeMultiplier extends Widget
{
  public function run() { 
    return view('DisposableTools::flight_time_multiplier'); 
  }
}
