<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use App\Models\Airport;

class SunriseSunset extends Widget
{
  protected $config = ['location' => null];

  public function run()
  {
    // Get The Airport
    $airport = Airport::find($this->config['location']);

    if(!$airport) {
      $error = "Airport Not Found !";
      return view('DisposableTools::sunrise_sunset',['error' => $error]);
    }

    // Get Sunrise/Sunset with full details
    $details = date_sun_info(time(), $airport->lat, $airport->lon);

    if(!$details) {
      $error = "Can Not Calculate Sunrise/Sunset Details For Given Coordinates !";
      return view('DisposableTools::sunrise_sunset',['error' => $error]);
    }

    foreach($details as $key => $value) {
      if($key === 'civil_twilight_begin') { $twilight_begin = $value; }
      if($key === 'civil_twilight_end') { $twilight_end = $value; }
      if($key === 'sunrise') { $sunrise = $value; }
      if($key === 'sunset') { $sunset = $value; }
    }

    return view('DisposableTools::sunrise_sunset',[
      'details'        => $details,
      'location'       => $this->config['location'],
      'twilight_begin' => $twilight_begin,
      'sunrise'        => $sunrise,
      'sunset'         => $sunset,
      'twilight_end'   => $twilight_end
      ]
    );
  }
}
