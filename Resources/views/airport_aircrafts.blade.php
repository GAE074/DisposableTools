<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">@lang('DisposableTools::common.aircrafts')<i class="fas fa-plane float-right"></i></h5>
  </div>
  <div class="card-body p-0 overflow-auto">
    @if(!$aircrafts->count())
      <span class="text-center m-1">@lang('DisposableTools::common.nothing')</span>
    @else
      <table class="table table-sm table-striped table-borderless mb-0 text-center">
        <tr>
          <th class="text-left">@lang('DisposableTools::common.reg')</th>
          <th>ICAO @lang('DisposableTools::common.type')</th>
          <th>@lang('common.airline')</th>
          <th>@lang('common.subfleet')</th>
        </tr>
        @foreach($aircrafts as $ac)
          <tr>
            <td class="text-left">@if ($ac->registration) {{ $ac->registration }} @endif</td>
            <td>{{ $ac->icao }}</td>
            <td>{{ $ac->subfleet->airline->name }}</td>
            <td>{{ $ac->subfleet->name }}</td>
          </tr>
        @endforeach
      </table>
    @endif
  </div>
  <div class="card-footer p-1 text-right">
    <span class="m-0 p-0">@lang('DisposableTools::common.total') : {{ number_format($aircrafts->count()) }}</span>
  </div>
</div>
