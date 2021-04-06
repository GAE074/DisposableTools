<?php

if (!function_exists('Dspt_PirepFields')) {
  // Check Pirep Field Values And Format Them
  // Return String with HTML codes
  function Dspt_PirepFields($field_slug,$field_value) {
    $error = null;
    if(is_numeric($field_value)) {
      // Landing Rate
      if($field_slug === 'landing-rate') {
        if($field_value > 0) { $error = " <i class='fas fa-exclamation-triangle ml-2' style='color:firebrick;' title='Positive Landing Rate !'></i>" ;}
        $field_value = number_format($field_value,2)." ft/min".$error;
      }
      // Threshold Distance
      elseif($field_slug === 'threshold-distance') {
        // $field_value = number_format($field_value)." ft".$error;
        if(setting('units.distance') === 'km' ) {
          $field_value = number_format($field_value / 3.2808)." m".$error;
        } else {
          $field_value = number_format($field_value)." ft".$error;
        }
      }
      // Landing G-Force
      elseif($field_slug === 'landing-g-force') {
        $field_value = number_format($field_value,2)." g".$error;
      }
      // Fuel Values
      elseif(strpos($field_slug, '-fuel') !== false) {
        if(setting('units.fuel') === 'kg') { $field_value = $field_value / 2.20462262185; }
        if($field_value < 0) { $error = " <i class='fas fa-exclamation-triangle ml-2' style='color:firebrick;' title='Negative Fuel !'></i>" ;}
        if($field_value <= 10) {
          $field_value = number_format($field_value, 2) ." ". setting('units.fuel').$error;
        } else {
          $field_value = number_format($field_value) ." ". setting('units.fuel').$error;
        }
      }
      // Weight Values
      elseif(strpos($field_slug, '-weight') !== false) {
        if(setting('units.weight') === 'kg') { $field_value = $field_value / 2.20462262185; }
        $field_value = number_format($field_value) ." ". setting('units.weight').$error;
      }
      // Pitch, Roll, Heading : Angle
      elseif(strpos($field_slug, 'roll') !== false || strpos($field_slug, 'pitch') !== false || strpos($field_slug, 'heading') !== false) {
        // $field_value = number_format($field_value,2)."&deg;".$error;
        $field_value = $field_value."&deg;".$error;
      }
      // Centerline Deviation : Distance
      elseif(strpos($field_slug, 'centerline-dev') !== false) {
        if(setting('units.distance') === 'km' ) {
          $field_value = number_format(($field_value / 3.2808),2)." m".$error;
        } else {
          $field_value = number_format($field_value,2)." ft".$error;
        }
      }
    }
    // Dates
    elseif(strpos($field_slug, 'off-time') !== false || strpos($field_slug, 'ing-time') !== false || strpos($field_slug, 'on-time') !== false) {
      $field_value = Carbon::parse($field_value)->format('H:i')." UTC";
    }
    return $field_value;
  }
}
