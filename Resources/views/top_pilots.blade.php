<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">
      @if ($config['count'] === 1)
        @lang('DisposableTools::common.bestpilot'): @if($rperiod){{ ucfirst($rperiod) }} | @endif {{ $rtype }}
        <i class="fas fa-star float-right"></i>
      @else
        @lang('DisposableTools::common.toppilots'): @if($rperiod){{ ucfirst($rperiod) }} | @endif {{ $rtype }}
        <i class="fas fa-medal float-right"></i>
      @endif
    </h5>
  </div>
  <div class="card-body p-0">
    @if(count($tpilots) > 0)
      <table class="table table-sm table-striped table-borderless mb-0 text-right">
        @if($config['count'] > 1)
          <tr>
            <th class="text-left">@lang('common.name')</th>
            <th>
              @if($config['type'] === 'landingrate')
                @lang('DisposableTools::common.avg')
              @elseif($config['type'] === 'time')
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
        @foreach($tpilots as $tp)
          <tr>
            <td class="text-left"><a href="{{ route('frontend.profile.show', [$tp->user_id]) }}">{{ $tp->user->name_private }}</a></td>
            <td>
              @if($config['type'] === 'time')
                @minutestotime($tp->totals)
              @elseif($config['type'] === 'distance')
                @if(setting('units.distance') === 'km')
                  {{ number_format($tp->totals * 1.852) }}
                @else
                  {{ number_format($tp->totals) }}
                @endif
                {{ setting('units.distance') }}
              @elseif($config['type'] === 'landingrate')
                {{ number_format($tp->totals) }} ft/min
              @else
                {{ number_format($tp->totals) }}
              @endif
            </td>
          </tr>
        @endforeach
      </table>
    @else
      <span class="m-1 text-center">@lang('DisposableTools::common.nothing')</span>
    @endif
  </div>
</div>
