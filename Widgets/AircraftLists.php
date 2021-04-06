<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use App\Models\Aircraft;
use Illuminate\Support\Facades\DB;

class AircraftLists extends Widget
{
  protected $config = ['type' => 'location']; 

  public function run() 
  {
    if ($this->config['type'] === 'location') { 
      $aircrafts = Aircraft::select(DB::raw('count(id) as result, airport_id'))
                ->groupBy('airport_id')
                ->orderBy('result','desc')
                ->get();
    } elseif ($this->config['type'] === 'icao') {
      $aircrafts = Aircraft::select(DB::raw('count(id) as result, icao'))
                ->groupBy('icao')
                ->orderBy('icao','asc')
                ->get();
    }

    return view('DisposableTools::aircraft_lists', [
      'aircrafts' => $aircrafts, 
      'config'    => $this->config,
      ]);
  }
}
