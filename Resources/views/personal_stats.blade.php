@if($config['disp'] === 'full')
  <div class="card mb-2 text-center">
    <div class="card-body p-1">
      <h5 class="m-1 p-0">
        @if($pstat)
          @if($config['type'] === 'avgtime' || $config['type'] === 'tottime')
            @minutestotime($pstat)
          @else
            {{ $pstat }}
          @endif
        @else
          @lang('DisposableTools::common.noreports')
        @endif
      </h5>
    </div>
    <div class="card-footer p-1">
      {{ $sname }} @if($speriod) ({{ $speriod }}) @endif
    </div>
  </div>
@else
  @if($pstat)
    @if($config['type'] === 'avgtime' || $config['type'] === 'tottime')
      @minutestotime($pstat)
    @else
      {{ $pstat }}
    @endif
  @else
    @lang('DisposableTools::common.noreports')
  @endif
@endif
