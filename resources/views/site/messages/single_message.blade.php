@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('site.top.topics') }}">Topics</a></li>
            <li class="breadcrumb-item">Messages</li>
            <li class="breadcrumb-item active" aria-current="page">{!! substr(strip_tags($message->body),0,15) !!}</li>
        </ol>
    </nav>

    <img src="/profile_pictures/{{ $message->user->profile_url }}" alt="" width="60" height="50">
    <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
       data-bs-placement="top" title="{{ $message->author }}" data-bs-content="
                                        Joined: {{ $message->user->joined_date  }}
        Level: {{ $message->user->level  }}
        Messages: {{ $message->where('author',$message->user->username)->count() }}
        ">
        <strong> {{ $message->author }} </strong>
    </a>
    @if(\Illuminate\Support\Facades\Auth::check())
        @if($user->username == $message->author)

            <button style="padding: 0 0 0 2px" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this message">
                <a href="{{ route('message.show.edit.form', $message->message_id) }}"><i class="fa fa-edit"></i></a>
            </button>

            <button style="padding: 0 0 0 2px"  id="delete-message" data-id="{{ $message->id }}" class="btn btn-lg text-secondary"
                    data-bs-toggle="tooltip" data-bs-placement="left" title="delete this message">
                <i class="fa fa-trash"></i>
            </button>
        @endif
    @endif

    <p class="message-body">
        {!! $message->body !!}
        <input type="hidden" id="message-id" value="{{ $message->id }}">
    </p>

   @include('site.messages.partials.message_actions')

    <!-----comments sections--->

    @include('site.messages.partials.message_comments')

    <!-----end comments sections--->


    <div class="" id="reply-editor">
        <p id="message-error-box"></p>
        <p id="reply-heading"></p>
        <div id="m-body" class="m-body"></div>
        @if(\Illuminate\Support\Facades\Auth::check())
            <h4 id="heading">write a comment for this thread...</h4>
            <form id="message-form">
                <textarea class="form-control summernote" name="body" id="body" rows="4"></textarea>
                <input type="hidden" id="message_id" value="{{ $message->id }}">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning" id="reply-message-button">
                        <i class="fa fa-comment"></i> Post Comment
                    </button>

                </div>
            </form>
    </div>
        @else
            <h4 class="text-center put-red">you should have an account to reply in the forum
                <a href="{{ route('user.show.register') }}">create one</a>
            </h4>
        @endif


        <script>
            $(document).on('click', '#btn_share_message', function () {
                console.log("clicked");
                const id = $(this).attr("share-id");
                document.getElementById(id).style.display = 'inline';
            });

        </script>

        <script type="text/javascript">
            $(document).on('click', '#btn_like_message', function () {
                const messageId = $(this).attr("like-id");

                $.ajax({
                    url: '/message/like',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'message_id': messageId,
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.status === 200){
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                            toastr.success("Message Liked successfully");
                        }else{
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                            toastr.error("Oops! An error occurred");
                        }

                        setTimeout(function (){
                            location.reload();
                            scrollToPosition();
                        },4000);
                    },

                    failure: function (response) {
                        console.log("something went wrong");
                    }
                });
            });

        </script>

        <script type="text/javascript">
            document.getElementById('body').addEventListener('input', function (){
                document.getElementById('reply-message-button').disabled = (this.value === '');
            });

            $('#reply-message-button').click(function(e){
                e.preventDefault();

                const body = $('#body').val();
                const messageId = $('#message-id').val();

                console.log(body);
                console.log(messageId);
                if(body !== "" ) {

                    $.ajax({
                        url: '/message/save/reply/',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'body': body,
                            'message_id':messageId,
                        },
                        success: function (response) {
                            console.log(response);
                            if(response.status === 200){
                                toastr.options =
                                    {
                                        "closeButton" : true,
                                        "progressBar" : true
                                    }
                                toastr.success("Comment sent successfully");
                            }else{
                                toastr.options =
                                    {
                                        "closeButton" : true,
                                        "progressBar" : true
                                    }
                                toastr.error("Oops! An error occurred");
                            }

                            setTimeout(function (){
                                location.reload();
                                scrollToPosition();
                            },4000);
                        },

                        failure: function (response) {
                            console.log("something went wrong");
                        }
                    });
                }else{
                    let content = '<small class="text-center put-red">' + "Error!Comment body cannot be empty" + '</small>';
                    $("#message-error-box").html(content);
                }
            });

        </script>

        <script type="text/javascript">

            $(document).on('click', '#delete-message',function(e) {
                // e.preventDefault();

                if (confirm("Are you sure want to delete this reply?")) {

                    const replyId = $(this).attr("data-id");

                    $.ajax({
                        url: '/ajax/delete/message',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'reply_id': replyId,
                        },
                        success: function (response) {

                            if(response.status === 200){
                                toastr.options =
                                    {
                                        "closeButton" : true,
                                        "progressBar" : true
                                    }
                                toastr.success("Reply deleted successfully");
                            }else{
                                toastr.options =
                                    {
                                        "closeButton" : true,
                                        "progressBar" : true
                                    }
                                toastr.error("Oops! An error occurred");
                            }
                            setTimeout(function (){
                                location.reload();
                                scrollToPosition();
                            },4000);
                        },

                        failure: function (response) {
                            console.log("something went wrong");
                        }
                    });
                }
            });

        </script>

        <script type="text/javascript">

            $(document).on('click', '#delete-comment-reply',function(e) {
                // e.preventDefault();

                if (confirm("Are you sure want to delete this comment?")) {

                    const comment_id = $(this).attr("data-id");

                    $.ajax({
                        url: '/message/delete/reply',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'comment_id': comment_id,
                        },
                        success: function (response) {
                            if(response.status === 200){
                                toastr.options =
                                    {
                                        "closeButton" : true,
                                        "progressBar" : true
                                    }
                                toastr.success("comment deleted successfully");
                            }else{
                                toastr.options =
                                    {
                                        "closeButton" : true,
                                        "progressBar" : true
                                    }
                                toastr.error("Oops! an error occurred");
                            }
                            setTimeout(function (){
                                location.reload();
                                scrollToPosition();
                            },4000);
                        },

                        failure: function (response) {
                            console.log("something went wrong");
                        }
                    });
                }
            });

        </script>

    <script type="text/javascript">
        //bookmark message
        function bookMark(messageId) {
            const message_Id = messageId;
            console.log(messageId);
            $.ajax({
                url: '/bookmark/topic_message',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'message_id': message_Id,
                    'role': 'message',
                },
                success: function (response) {
                    console.log(response);

                    if (response.status === 200) {
                        toastr.options =
                            {
                                "closeButton": true,
                                "progressBar": true
                            }
                        toastr.success(response.message);

                        setTimeout(function (){
                            location.reload();
                            scrollToPosition();
                        },4000);

                    } else {
                        toastr.options =
                            {
                                "closeButton": true,
                                "progressBar": true
                            }
                        toastr.error("Oops! An error occurred");
                    }

                },

                failure: function (response) {
                    console.log("something went wrong");
                }
            });
        }
    </script>

@endsection
