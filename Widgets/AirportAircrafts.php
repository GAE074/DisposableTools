<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use App\Models\Aircraft;
use App\Models\Enums\AircraftState;
use App\Models\Enums\AircraftStatus;

class AirportAircrafts extends Widget
{
  protected $config = ['location' => 'ZZZZ'];

  public function run() 
  {
    $aircrafts = Aircraft::where('airport_id', $this->config['location'])
        ->where('state', AircraftState::PARKED)
        ->where('status', AircraftStatus::ACTIVE)
        ->orderBy('icao')
        ->orderBy('registration')
        ->get();

    return view('DisposableTools::airport_aircrafts', [
      'aircrafts' => $aircrafts,
      ]);
  }
}
