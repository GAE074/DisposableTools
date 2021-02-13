<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">Top {{ $count }} Airlines By {{ ucfirst($type) }}<i class="fas fa-medal float-right"></i></h5>
  </div>
  <div class="card-body p-0">
    @if(count($tairlines) > 0)
      <table class="table table-sm table-striped table-borderless mb-0 text-right">
        <tr>
          <th class="text-left">Name</th>
          <th>{{ ucfirst($type) }}</th>
        </tr>
        @foreach($tairlines as $ta)
          <tr>
            <td class="text-left"><a href="{{ route('TurkSim.airline') }}?aid={{ $ta->airline_id }}">{{ $ta->airline->name }}</a></td>
            @if($type === 'time')
              <td> @minutestotime($ta->totals) </td>
            @elseif($type === 'distance')
              <td> @if (setting('units.distance') === 'km') {{ number_format($ta->totals * 1.852) }} @else {{ number_format($ta->totals) }} @endif {{ setting('units.distance') }}</td>
            @else
              <td> {{ number_format($ta->totals) }}</td>
            @endif
          </tr>
        @endforeach
      </table>
    @else
      No Stats Available
    @endif
  </div>
</div>
