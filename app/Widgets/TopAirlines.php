<?php

namespace App\Widgets;

use App\Models\Pirep;
use App\Contracts\Widget;
use Illuminate\Support\Facades\DB;

class TopAirlines extends Widget
{
  protected $config = ['count' => 3, 'type' => 'flights'];

  public function run()
  {
    if ($this->config['type'] === 'flights') { $rawsql = DB::raw('count(airline_id) as totals'); }
    if ($this->config['type'] === 'distance') { $rawsql = DB::raw('sum(distance) as totals'); }
    if ($this->config['type'] === 'time') { $rawsql = DB::raw('sum(flight_time) as totals'); }

    $tairlines = Pirep::select('airline_id', $rawsql)
                ->where('state', 2)
                ->orderby('totals', 'desc')
                ->groupby('airline_id')
                ->take($this->config['count'])
                ->get();

    return view('widgets.topairlines', [
      'tairlines' => $tairlines,
      'type'      => $this->config['type'],
      'count'     => $this->config['count'],
    ]);
  }
}
