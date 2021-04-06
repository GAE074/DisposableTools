<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">
      @if($airlineid) @lang('common.airline') @endif @lang('DisposableTools::common.stats')
      <i class="fas fa-folder-open float-right"></i>
    </h5>
  </div>
  <div class="card-body p-0">
    <table class="table table-sm table-striped table-borderless mb-0 text-left">
      <tr>
        <th style="width: 50%">{{ trans_choice('common.pilot', 2) }}</th>
        <td class="text-right">{{ $totalpilot }}</td>
      </tr>
      <tr>
        <th>@lang('DisposableTools::common.aircrafts')</th>
        <td class="text-right">{{ $totalaircraft }}</td>
      </tr>
      <tr>
        <th>{{ trans_choice('common.flight', 2) }}</th>
        <td class="text-right">{{ $totalflight }}</td>
      </tr>
      <tr>
        <th style="width: 50%">{{ trans_choice('common.pirep', 2) }}</th>
        <td class="text-right">{{ $totalpirep }}</td>
      </tr>
      <tr>
        <th>@lang('pireps.flighttime')</th>
        <td class="text-right"> @minutestotime($totaltime)</td>
      </tr>
      @if($totaldistance > 0)
        <tr>
          <th>@lang('common.distance')</th>
          <td class="text-right">{{ $totaldistance }} {{ setting('units.distance') }}</td>
        </tr>
      @endif
      @if($avgdist > 0)
        <tr>
          <th>@lang('DisposableTools::common.avg') @lang('common.distance')</th>
          <td class="text-right">{{ $avgdist }} {{ setting('units.distance') }}</td>
        </tr>
      @endif
      <tr>
        <th>@lang('pireps.fuel_used')</th>
        <td class="text-right">{{ $totalfuel }} {{ setting('units.fuel') }}</td>
      </tr>
      <tr>
        <th>@lang('DisposableTools::common.avg') @lang('pireps.fuel_used') / {{ trans_choice('common.flight',1) }}</th>
        <td class="text-right">{{ $avgfuel }} {{ setting('units.fuel') }}</td>
      </tr>
      <tr>
        <th>@lang('DisposableTools::common.avg') @lang('pireps.fuel_used') / @lang('DisposableTools::common.hour')</th>
        <td class="text-right">{{ $avgfuelh }} {{ setting('units.fuel') }}</td>
      </tr>
    </table>
  </div>
</div>
