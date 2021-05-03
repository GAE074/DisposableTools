<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">
      @lang('DisposableTools::common.stats'): {{ $acreg ?? '' }} @if($acreg != $acname) '{{ $acname ?? '' }}' @endif
      <i class="fas fa-file-alt float-right"></i>
    </h5>
  </div>
  <div class="card-body p-0">
    <table class="table table-sm table-borderless table-striped mb-0 text-left">
      @if($acpirepc > 0)
        <tr>
          <th scope="row">{{ trans_choice('common.pirep', 2) }}</th>
          <td class="text-right">{{ $acpirepc }}</td>
        </tr>
        <tr>
          <th scope="row">@lang('pireps.flighttime')</th>
          <td class="text-right">@minutestotime($acflttime)</td>
        </tr>
        <tr>
          <th scope="row">@lang('common.distance')</th>
          <td class="text-right">{{ number_format($acdistance) }} {{ setting('units.distance') }}</td>
        </tr>
        <tr>
          <th scope="row">@lang('pireps.fuel_used')</th>
          <td class="text-right">{{ number_format($acfuelused) }} {{ setting('units.fuel') }}</td>
        </tr>
        <tr>
          <th scope="row">@lang('DisposableTools::common.avg') @lang('pireps.fuel_used') / @lang('DisposableTools::common.hour')</th>
          <td class="text-right">{{ number_format($acavgfuelh) }} {{ setting('units.fuel') }}</td>
        </tr>
        <tr>
          <th scope="row">@lang('DisposableTools::common.avglanding')</th>
          <td class="text-right">{{ number_format($acavglrate) }} ft/min</td>
        </tr>
      @else
        <tr>
          <td class="text-center">@lang('DisposableTools::common.nothing')</td>
        </tr>
      @endif
    </table>
  </div>
</div>
