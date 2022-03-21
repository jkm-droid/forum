@extends('base.index')

@section('content')


        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Notifications</li>
                <li class="breadcrumb-item active" aria-current="page">View All</li>
            </ol>
        </nav>
        <div class="row col-md-12">
            <div class="col-md-2" style="margin-right: 0;">
                @include('includes.profile.picture')
            </div>

            <div class="col-md-10 profile-section text-start">

                @include('includes.profile.description')

                @include('includes.notifications')

            </div>

        </div>

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
