<?php

namespace App\Widgets;

use Carbon;
use App\Models\Pirep;
use App\Contracts\Widget;
use Illuminate\Support\Facades\DB;

class TopAirlinesByPeriod extends Widget
{
  protected $config = ['count' => 3, 'type' => 'flights', 'period' => 'currentm'];

  public function run()
  {
    $periodselection = $this->config['period'];
    $wheretype = 'whereMonth';

    if ($periodselection === 'currentm')
    {
      $repsql = Carbon::now()->month;
      $period = Carbon::now()->format('F');
    }

    if ($periodselection === 'lastm')
    {
      $repsql = Carbon::now()->subMonth()->month;
      $period = Carbon::now()->subMonth()->format('F');
    }

    if ($periodselection === 'prevm')
    {
      $repsql = Carbon::now()->subMonth(2)->month;
      $period = Carbon::now()->subMonth(2)->format('F');
    }

    if ($periodselection === 'currenty')
    {
      $wheretype = 'whereYear';
      $repsql = Carbon::now()->year;
      $period = Carbon::now()->format('Y');
    }

    if ($periodselection === 'lasty')
    {
      $wheretype = 'whereYear';
      $repsql = Carbon::now()->subYear()->year;
      $period = Carbon::now()->subYear()->format('Y');
    }

    if ($this->config['type'] === 'flights') { $rawsql = DB::raw('count(airline_id) as totals'); }
    if ($this->config['type'] === 'distance') { $rawsql = DB::raw('sum(distance) as totals'); }
    if ($this->config['type'] === 'time') { $rawsql = DB::raw('sum(flight_time) as totals'); }

    $tairlines = Pirep::select('airline_id', $rawsql)
                    ->where('state', '2')
                    ->$wheretype('created_at', '=', $repsql)
                    ->orderBy('totals', 'desc')
                    ->groupBy('airline_id')
                    ->take($this->config['count'])
                    ->get();

    return view('widgets.topairlinesbyperiod', [
        'tairlines' => $tairlines,
        'type'      => $this->config['type'],
        'count'     => $this->config['count'],
        'rperiod'   => $period,
        ]);
  }
}
