<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use App\Models\Aircraft;
use App\Models\Flight;
use App\Models\Pirep;
use App\Models\Subfleet;
use App\Models\User;
use App\Models\Enums\PirepState;

class AirlineStats extends Widget
{
  protected $config = ['airline' => null];

  public function run()
  {
    if ($this->config['airline']) {
      $airlineid = $this->config['airline'];
      $totalpilot = User::where('airline_id', $airlineid)->count();
      $subfleets = Subfleet::where('airline_id', $airlineid)->select('id')->get();
      $subfleets = $subfleets->toArray();
      $totalaircraft = Aircraft::whereIn('subfleet_id', $subfleets)->count();
      $totalflight = Flight::where('airline_id', $airlineid)->count();
      $totalpirep = Pirep::where('airline_id', $airlineid)->where('state', PirepState::ACCEPTED)->count();
      $totaltime = Pirep::where('airline_id', $airlineid)->where('state', PirepState::ACCEPTED)->sum('flight_time');
      $totaldistance = Pirep::where('airline_id', $airlineid)->where('state', PirepState::ACCEPTED)->sum('distance');
      $totalfuel = Pirep::where('airline_id', $airlineid)->where('state', PirepState::ACCEPTED)->sum('fuel_used');
    } else {
      $totalpilot = User::count();
      $totalaircraft = Aircraft::count();
      $totalflight = Flight::count();
      $totalpirep = Pirep::where('state', PirepState::ACCEPTED)->count();
      $totaltime = Pirep::where('state', PirepState::ACCEPTED)->sum('flight_time');
      $totaldistance = Pirep::where('state', PirepState::ACCEPTED)->sum('distance');
      $totalfuel = Pirep::where('state', PirepState::ACCEPTED)->sum('fuel_used');
    }

    if ($totalpirep === 0) {
      $avgfuel = 0;
      $avgfuelh = 0;
      $avgdist = 0;
    } else {
      $avgfuel = $totalfuel / $totalpirep;
      $avgfuelh = ($totalfuel / $totaltime) * 60;
      $avgdist = $totaldistance / $totalpirep;
    }

    if (setting('units.distance') === 'km') {
      $totaldistance = number_format($totaldistance * 1.852);
      $avgdist = number_format($avgdist * 1.852);
    } elseif (setting('units.distance') === 'mi') {
      $totaldistance = number_format($totaldistance * 1.15078);
      $avgdist = number_format($avgdist * 1.15078);
    } else {
      $totaldistance = number_format($totaldistance);
      $avgdist = number_format($avgdist);
    }

    if (setting('units.fuel') === 'kg') {
      $totalfuel = number_format($totalfuel / 2.20462262185);
      $avgfuel = number_format($avgfuel / 2.20462262185);
      $avgfuelh = number_format($avgfuelh / 2.20462262185);
    } else {
      $totalfuel = number_format($totalfuel);
      $avgfuel = number_format($avgfuel);
      $avgfuelh = number_format($avgfuelh);
    }

    return view('DisposableTools::airline_stats', [
        'totalpilot'    => $totalpilot,
        'totalaircraft' => $totalaircraft,
        'totalflight'   => $totalflight,
        'totalpirep'    => $totalpirep,
        'totaltime'     => $totaltime,
        'totaldistance' => $totaldistance,
        'totalfuel'     => $totalfuel,
        'avgfuel'       => $avgfuel,
        'avgfuelh'      => $avgfuelh,
        'avgdist'       => $avgdist,
        'airlineid'     => $this->config['airline'],
        ]);
  }
}
