<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">
      @if ($config['type'] === 'dep')
        <i class="fas fa-plane-departure float-right"></i>
        @lang('DisposableTools::common.topairports'): @lang('common.departure')
      @elseif ($config['type'] === 'arr')
        <i class="fas fa-plane-arrival float-right"></i>
        @lang('DisposableTools::common.topairports'): @lang('common.arrival')
      @endif
    </h5>
  </div>
  <div class="card-body p-0">
    <table class="table table-sm table-striped table-borderless mb-0 text-right">
      <tr>
        <th class="text-left">@lang('common.name')</th>
        <th>@lang('DisposableTools::common.count')</th>
      </tr>
      @foreach($tairports as $ta)
        <tr>
          <td class="text-left">
            @if($config['type'] === 'dep')
              <a href="{{ route('frontend.airports.show', [$ta->dpt_airport_id]) }}">{{ $ta->dpt_airport->name ?? $ta->dpt_airport_id }}</a>
            @elseif($config['type'] === 'arr')
              <a href="{{ route('frontend.airports.show', [$ta->arr_airport_id]) }}">{{ $ta->arr_airport->name ?? $ta->arr_airport_id }}</a>
            @endif
          </td>
          <td>{{ number_format($ta->tusage) }}</td>
        </tr>
      @endforeach
    </table>
  </div>
</div>
