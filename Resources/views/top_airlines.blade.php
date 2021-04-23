<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">
      @if ($config['count'] === 1)
        @lang('DisposableTools::common.bestairline'): @if($rperiod){{ ucfirst($rperiod) }} | @endif {{ $rtype }}
        <i class="fas fa-trophy float-right"></i>
      @else
        @lang('DisposableTools::common.topairlines'): @if($rperiod){{ ucfirst($rperiod) }} | @endif {{ $rtype }}
        <i class="fas fa-paper-plane float-right"></i>
      @endif
    </h5>
  </div>
  <div class="card-body p-0">
    @if(count($tairlines) > 0)
      <table class="table table-sm table-striped table-borderless mb-0 text-right">
        @if($config['count'] > 1)
          <tr>
            <th class="text-left">@lang('common.name')</th>
            <th>
              @if($config['type'] === 'time')
                @lang('pireps.flighttime')
              @elseif($config['type'] === 'distance')
                @lang('common.distance')
              @elseif($config['type'] === 'flights')
                {{ trans_choice('common.flight',2) }}
              @else
                @lang('DisposableTools::common.count')
              @endif
            </th>
          </tr>
        @endif
        @foreach($tairlines as $ta)
          <tr>
            <td class="text-left">{{ $ta->airline->name ?? 'Deleted Airline' }}</td>
          @if($config['type'] === 'time')
            <td>@minutestotime($ta->totals)</td>
          @elseif($config['type'] === 'distance')
            <td>
              @if(setting('units.distance') === 'km')
                {{ number_format($ta->totals * 1.852) }}
              @elseif(setting('units.distance') === 'mi')
                {{ number_format($ta->totals * 1.15078) }}
              @else
                {{ number_format($ta->totals) }}
              @endif
              {{ setting('units.distance') }}
            </td>
          @else
            <td>{{ number_format($ta->totals) }}</td>
          @endif
          </tr>
        @endforeach
      </table>
    @else
      <span class="m-1 text-center">@lang('DisposableTools::common.nothing')</span>
    @endif
  </div>
</div>
