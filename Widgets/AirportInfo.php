<?php

namespace Modules\DisposableTools\Widgets;

use App\Contracts\Widget;
use App\Repositories\AirportRepository;

/* Widget Designed By MacoFallico */
class AirportInfo extends Widget
{
  private $airportRepo;

  public function __construct(
      AirportRepository $airportRepo
  ) {
      $this->airportRepo = $airportRepo;
  }

  public function run()
  {
    $airports = $this->airportRepo->select('id', 'name', 'location', 'country')
      ->orderBy('id')
      ->get();

    return view('DisposableTools::airport_info', [
      'airports' => $airports,
      ]);
  }
}
