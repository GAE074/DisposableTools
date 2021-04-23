<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use App\Models\Aircraft;
use App\Models\Pirep;
use App\Models\Enums\PirepState;
use App\Models\Enums\PirepSource;

class AircraftStats extends Widget
{
  protected $config = ['id' => null];

  public function run()
  {
    if ($this->config['id']) {
      $ac = Aircraft::find($this->config['id']);
      if(!$ac) {
        $acreg = null;
        $acname = null;
      } else {
        $acreg = $ac->registration;
        $acname = $ac->name;
      }
      // Build Main Query
      $squery = Pirep::where('aircraft_id', $this->config['id'])->where('state', PirepState::ACCEPTED);
      // Get Data
      $acpirepc = $squery->count();
      $acflttime = $squery->sum('flight_time');
      $acfuelused = $squery->where('source', PirepSource::ACARS)->sum('fuel_used');
      $acdistance = $squery->where('source', PirepSource::ACARS)->sum('distance');
      $acavglrate = $squery->where('source', PirepSource::ACARS)->avg('landing_rate');
      if (!$acflttime) {
        $acavgfuelh = null;
      } else {
        $acavgfuelh = ($acfuelused / $acflttime) * 60;
      }
      // Covert According to settings
      if (setting('units.fuel') === 'kg') {
        $acfuelused = $acfuelused / 2.20462262185;
        $acavgfuelh = $acavgfuelh / 2.20462262185;
      }
      if (setting('units.distance') === 'km') {
        $acdistance = $acdistance * 1.852;
      } elseif (setting('units.distance') === 'mi') {
        $acdistance = $acdistance * 1.15078;
      }

      return view('DisposableTools::aircraft_stats', [
        'acreg'      => $acreg,
        'acname'     => $acname,
        'acpirepc'   => $acpirepc,
        'acflttime'  => $acflttime,
        'acfuelused' => $acfuelused,
        'acdistance' => $acdistance,
        'acavglrate' => $acavglrate,
        'acavgfuelh' => $acavgfuelh,
      ]);
    }
  }
}
