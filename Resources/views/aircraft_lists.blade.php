<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">@lang('DisposableTools::common.aircrafts')<i class="fas fa-plane float-right"></i></h5>
  </div>
  <div class="card-body p-0">
    <table class="table table-sm table-striped table-borderless mb-0 text-left">
      <tr>
        <th>
          @if($config['type'] === 'icao') 
            ICAO @lang('DisposableTools::common.type')
          @elseif($config['type'] === 'location') 
            @lang('DisposableTools::common.location')
          @endif
        </th>
        <th class="text-right">@lang('DisposableTools::common.count')</th>
      </tr>
      @foreach($aircrafts as $ac)
        <tr>
          <td>
            @if ($config['type'] === 'icao') 
              {{ $ac->icao }}
            @elseif ($config['type'] === 'location') 
              <a href="{{route('frontend.airports.show', [$ac->airport_id])}}">{{ $ac->airport->name ?? $ac->airport_id}}</a>
            @endif
          </td>
          <td class="text-right">{{ $ac->result }}</td>
        </tr>
      @endforeach
    </table>
  </div>
</div>
