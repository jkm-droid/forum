@extends('base.index')

@section('content')

    @if($notifications->isEmpty())
        <h4 class="text-center">No notification found.</h4>
    @else
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-2 topic-creation-categories">
                @include('includes.short_forum_list')
            </div>

            <div class="col-md-10 card card-outline card-warning">
                <h5>Notifications</h5>

                    @foreach($notifications as $notification)

                        <div class="notifications card card-outline m-2 " style="padding: 5px;">
                            <p>
                                {{ $notification->created_at }}<br>
                                <strong>{{ $notification->data['author'] }}</strong> reacted to your post <strong>{{ $notification->data['topic_title'] }}</strong>.
                                <a class="btn badge bg-danger right"  href="">view</a>
                                <button class="btn badge bg-info" id="mark-as-read" data-id="{{ $notification->id }}">mark as read</button>
                            </p>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-danger" id="staticBackdropLabel"></h5>
                                        <i data-bs-dismiss="modal" aria-label="Close" class="fa fa-times"></i>
                                    </div>
                                    <input type="hidden" value="{{ $notification->data['message_id'] }}" id="article-id">
                                    <div class="modal-body">
{{--                                        <p>{!! $notification->data['body'] !!}</p>--}}
                                    </div>

                                </div>
                            </div>
                        </div>

                    @endforeach
{{--                    <a href="#" id="mark-all-as-read" class="badge bg-info col-md-1 ml-2">Mark all as Read</a>--}}

            </div>
            <!-- /.card -->
        </div>

    @endif
    <script>
        $(document).on('click', '#mark-as-read', function (e) {
            e.preventDefault();
            var notification_id = $(this).attr('data-id');

            $.ajax({
                url: '{{ url('notifications/mark_as_read')}}/'+notification_id,
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
                        $(this).parents('div.notifications').remove();
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
