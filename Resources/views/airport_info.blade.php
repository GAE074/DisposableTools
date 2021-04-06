<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1 p-0">
      @lang('DisposableTools::common.airportinfo')
      <i class="fas fa-info-circle float-right"></i>
    </h5>
  </div>
  <div class="card-body p-1">
    <select id="airportselector" class="form-control select2" onchange="checkapselection()">
      <option value="ZZZZ">@lang('DisposableTools::common.selectap')</option>
      @foreach($airports as $airport)
        <option value="{{ $airport->id }}">{{ $airport->id }} : {{ $airport->name ?? '' }} ({{ $airport->location ?? ''}})</option>
      @endforeach
    </select>
  </div>
  <div class="card-footer p-1 text-right">
    <a id="generate_link" style="visibility: hidden;" href="{{route('frontend.airports.show','' ) }}" class="btn btn-sm btn-secondary">@lang('DisposableTools::common.go')</a>
  </div>
</div>

<script type="text/javascript">
  // Simple Selection With Dropdown Change
  // Also keep button hidden until a valid selection
  const $oldlink = document.getElementById("generate_link").href;

  function checkapselection() {
    if (document.getElementById("airportselector").value === "ZZZZ") {
      document.getElementById('generate_link').style.visibility = 'hidden';
    } else {
      document.getElementById('generate_link').style.visibility = 'visible';
    }
    const selectedap = document.getElementById("airportselector").value;
    const newlink = "/".concat(selectedap);
    document.getElementById("generate_link").href = $oldlink.concat(newlink);
  }
</script>
