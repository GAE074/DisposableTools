@if($activeusers->count())
  <div class="card mb-2">
    <div class="card-header p-1">
      <h5 class="m-1 p-0">
        @lang('DisposableTools::common.activeu')
        <i class="fas fa-users float-right"></i>
      </h5>
    </div>
    <div class="card-body p-0">
      <table class="table table-borderless table-sm table-striped mb-0 text-left">
        @foreach($activeusers->sortBy('user_id') as $au)
          <tr>
            <th><a href="{{ route('frontend.profile.show', [$au->user_id]) }}">{{ $au->user->name_private ?? '' }}</a></th>
            <td class="text-right">{{ Carbon::createFromTimestamp($au->last_activity)->diffForHumans() }}</td>
          </tr>
        @endforeach
      </table>
    </div>
  </div>
@endif
