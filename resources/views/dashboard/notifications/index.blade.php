@extends('base.admin')

@section('content')
    @if(count($notifications) <= 0)
        <h4 class="text-center">No notification found.</h4>
    @else
        <div class="card">
            <div class="card-header">
                <h5>Current Notifications ({{ count($notifications) }})</h5>
            </div>
            <div class="card-body">
                @foreach ($notifications as $notification)
                    {{ $notification['created_at'] }}
                    <h6>
                        <strong>{{ $notification->data['author'] }}</strong> created a new topic <strong>{{ $notification->data['topic_title'] }}</strong> at
                        {{ \Carbon\Carbon::parse($notification['time'])->format('j M, Y H:m') }}

                    <button class="btn badge bg-info text-white" id="mark-as-read" data-id="{{ $notification['id'] }}">mark as read</button>
                    </h6>
                    <hr>
                @endforeach
            </div>
        </div>
    @endif

    <script>
        $(document).on('click', '#mark-as-read', function (e) {
            e.preventDefault();
            var notification_id = $(this).attr('data-id');

            $.ajax({
                url: '{{ url('admin/notifications/mark_as_read')}}/'+notification_id,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'notification_id' : notification_id,
                },
                success: function (response) {
                    if(response.status === 200){
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.success("Marked as read");
                    }else{
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.error("Oops! An error occurred");
                    }

                    // location.reload();
                },

                failure: function (response) {
                    console.log("something went wrong");
                }
            });
        });
    </script>
    <script>
        $(document).on('click', 'button[article-id]', function (e) {
            e.preventDefault();
            var article_id = $('#article-id').val();
            console.log(article_id);

            $.ajax({
                url: '{{ url('notifications/publish/ajax')}}/'+article_id,
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'article_id' : article_id,
                },
                success: function (response) {
                    if(response.status === 200){
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.success("Article published successfully");
                        $(this).parents('div.notifications').remove();
                        window.location.reload();
                    }else{
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.error("Oops! An error occurred");

                    }
                },

                failure: function (response) {
                    console.log("something went wrong");
                }
            });
        });
    </script>

@endsection
