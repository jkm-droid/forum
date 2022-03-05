<h5>Activity Log</h5>
@if(count($activities) > 0)
    @foreach($activities as $activity)
        <p>
            {{ $activity->created_at }} :
            {!! $activity->activity_body !!}
        </p>
    @endforeach
@else
    @include('admin_partials.alert')

    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
        <div>
            Oops! No activity logs found
        </div>
    </div>
@endif
