@if($notifications->isEmpty())
    <h4 class="text-center text-danger">No notifications found!!</h4>
@else
{{--    <div class="card">--}}
        <h4 style="margin-left: 5px;">Notifications</h4>

        @foreach($notifications as $notification)

            <div class="notifications card card-outline m-2 " style="padding: 5px;">
                <p>
                    {{ $notification->created_at }}<br>
                    {!! $notification->data['message'] !!} at <span style="font-size: small">{{ \Carbon\Carbon::parse($notification->data['time'])->format('Y-M-d H:m:s') }}</span>
                    <button class="btn badge bg-info" id="mark-as-read" data-id="{{ $notification->id }}">mark as read</button>
                </p>
            </div>
        @endforeach
        {{--                    <a href="#" id="mark-all-as-read" class="badge bg-info col-md-1 ml-2">Mark all as Read</a>--}}

{{--    </div>--}}
@endif
