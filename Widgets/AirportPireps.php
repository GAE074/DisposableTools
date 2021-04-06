<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use App\Models\Pirep;
use App\Models\Enums\PirepState;
use App\Models\Enums\PirepStatus;

class AirportPireps extends Widget
{
  protected $config = ['location' => 'ZZZZ'];

  public function run() 
  {
    $pireps = Pirep::where('dpt_airport_id', $this->config['location'])
                ->where('state', PirepState::ACCEPTED)
                ->where('status', PirepStatus::ARRIVED)
                ->orWhere('arr_airport_id', $this->config['location'])
                ->where('state', PirepState::ACCEPTED)
                ->where('status', PirepStatus::ARRIVED)
                ->orderBy('submitted_at', 'desc')
                ->get();

    return view('DisposableTools::airport_pireps', [
      'pireps' => $pireps,
      'config' => $this->config,
      ]);
  }
}
