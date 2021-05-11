<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Pirep;
use Illuminate\Support\Facades\Auth;

class FlightsMap extends Widget
{
  protected $config = ['source' => 0, 'visible' => true, 'limit' => null];

  public function run()
  {
    $source = $this->config['source'];
    $mapcenter = setting('acars.center_coords');

    // Get User Details
    $user = Auth::user();
    if($user->current_airport) {
      $user_a = $user->current_airport->id;
      $user_loc = $user->current_airport->lat.",".$user->current_airport->lon;
    } else {
      $user_a = $user->home_airport->id;
      $user_loc = $user->home_airport->lat.",".$user->home_airport->lon;
    }

    // Define The Type
    if ($source === 0) {
      $type = 'generic';
    } elseif (is_numeric($source) && $source != 0) {
      $airline_id = $source;
      $type = 'airline';
    } elseif ($source === 'user') {
      $type = 'user';
    } else {
      $airport_id = $source;
      $type = 'airport';
    }

    if ($type === 'user') {
      // Get User Pireps
      $mapflights = Pirep::where('user_id', $user->id)->where('state', 2)->where('status', 'ONB')->orderby('submitted_at', 'desc')->get();
    }
    elseif ($type === 'generic') {
      // Generic Map : May Be Used at Flight Search or Somewhere Else To Show All Flights !
      $mapflights = Flight::where('active', 1)->orderby('flight_number')->get();
    }
    elseif ($type === 'airline') {
      // Airline Flights Map : May Be Used at Disposable Airlines Module
      $mapflights = Flight::where('active', 1)->where('airline_id', $airline_id)->orderby('flight_number')->get();
    }
    elseif ($type === 'airport') {
      // Airport Flights Map : May Be Used at Disposable Hubs Module or with Generic Airport Details Page
      $mapflights = Flight::where('active', 1)->where('dpt_airport_id', $airport_id)->orWhere('arr_airport_id', $airport_id)->get();
    }

    // Filter Flights to User's Company
    if($type === 'generic' && setting('pilots.restrict_to_company') || $type === 'airport' && setting('pilots.restrict_to_company')) {
      $mapflights = $mapflights->where('airline', $user->airline_id);
    }
    // Filter Flights To User's Current Location
    if($type === 'generic' && setting('pilots.only_flights_from_current')) {
      $mapflights = $mapflights->where('dpt_airport_id', $user_a);
      $mapcenter = $user_loc;
    }
    // Filter Visible Flights
    if($this->config['visible'] && $type != 'user') {
      $mapflights = $mapflights->where('visible', 1);
    }
    // Get The Flights/Pireps With Applied Limit
    if(is_numeric($this->config['limit'])) {
      $mapflights = $mapflights->take($this->config['limit']);
    }

    // Build Unique City Pairs From Flights/Pireps
    $citypairs = [];
    foreach($mapflights as $mf) {
      $reverse = $mf->arr_airport_id.$mf->dpt_airport_id;
      if(Dispo_In_Array_MD($reverse,$citypairs)) { continue; }

      $citypairs[] = array(
        'name' => $mf->dpt_airport_id.$mf->arr_airport_id,
        'dloc' => $mf->dpt_airport->lat.",".$mf->dpt_airport->lon,
        'aloc' => $mf->arr_airport->lat.",".$mf->arr_airport->lon
      );
    }
    $citypairs = Dispo_Array_Unique_MD($citypairs,'name');

    // Get Unique Airports
    $departures = $mapflights->pluck('dpt_airport_id')->all();
    $arrivals = $mapflights->pluck('arr_airport_id')->all();
    $used_airports = array_merge($departures,$arrivals);
    $used_airports = array_unique($used_airports, SORT_STRING);
    $airports = Airport::whereIn('id', $used_airports)->get();

    if($type === 'airport') {
      foreach($airports->where('id', $airport_id) as $center) {
        $mapcenter = $center->lat.",".$center->lon;
      }
    }

    return view('DisposableTools::flights_map',[
      'mapcenter'  => $mapcenter,
      'mapflights' => $mapflights,
      'mapsource'  => $type,
      'citypairs'  => $citypairs,
      'airports'   => $airports,
      ]
    );
  }
}
