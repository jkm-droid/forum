@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('site.top.topics') }}">Topics</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $topic->title }}</li>
        </ol>
    </nav>

    @include('site.topics.partials.topic_section')

    <!------------messages section-------------->

   @include('site.topics.partials.topic_messages')

    <!------------end messages section-------------->

    <div class="" id="reply-editor">
        <p id="message-error-box"></p>
        <p id="reply-heading"></p>
        <div id="m-body" class="m-body"></div>
        @if(\Illuminate\Support\Facades\Auth::check())
            <h4 id="heading">write a message for this topic...</h4>

            <form id="message-form">
                <textarea class="form-control summernote" name="body" id="body" rows="4"></textarea>
                <input type="hidden" id="topic_id" value="{{ $topic->id }}">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning" id="reply-topic-button">
                        <i class="fa fa-reply"></i> Post Reply
                    </button>
                    <button type="submit" class="btn btn-warning" id="reply-message-button" style="display: none">
                        <i class="fa fa-reply"></i> Post Reply
                    </button>
                </div>
            </form>

        @else
            <h4 class="text-center put-red">you should have an account to reply in this section
                <a href="{{ route('user.show.register') }}">create one</a>
            </h4>
        @endif
    </div>

    <script>
        $(document).on('click', '#btn_show_reactions', function () {
            const id = $(this).attr("comment-id");
            const btnId = "comment-"+id;
            const btnClass = "comment-btn-"+id;
            $('.'+btnClass).css('display','none');
            document.getElementById(btnId).style.display = 'block';
        });
    </script>

    <script>
        $(document).on('click', '#btn_share_topic', function () {
            console.log("clicked");
            const id = $(this).attr("share-id");
            document.getElementById(id).style.display = 'inline';
        });

    </script>

    <script>
        $(document).on('click', '#btn_share_message', function () {
            const id = $(this).attr("share-id");
            console.log(id);
            document.getElementById(id).style.display = 'inline';
        });

    </script>

    <script>
        $(document).on('click', '#btn_post_reply', function(){
            document.getElementById('reply-editor').scrollIntoView();
            const id = $(this).attr("reply-id");
            const mBody = $(this).attr("reply-body");
            // console.log(document.getElementById(id));
            document.getElementById('heading').style.display = 'none';
            document.getElementById('reply-heading').innerText = "Replying to:";
            document.getElementById('reply-topic-button').style.display = 'none';
            document.getElementById('reply-message-button').style.display = 'block';

            const para = '<p>'+mBody+'</p>';
            $( '.m-body' ).append(para);
            $('#reply-editor').append('<input type="hidden" value="'+id+'" class="message_id" placeholder="name" id="message-id"/>');
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
        const inputBody = document.getElementById('body');
        const btn = document.getElementById('reply-topic-button');

        inputBody.addEventListener('input', function (){
            btn.disabled = (this.value === '');
        });

        $('#reply-topic-button').click(function(e){
            e.preventDefault();

            const body = $('#body').val();
            const topicId = $('#topic_id').val();

            if(body !== "" ) {

                $.ajax({
                    url: '/save/message',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'body': body,
                        'topic_id':topicId,
                    },
                    success: function (response) {
                        console.log(response);
                        let content = "";

                        if(response.status === 200){
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                            toastr.success("Reply sent successfully");
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
                let content = '<small class="text-center put-red">' + "Error!Thread body cannot be empty" + '</small>';
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
                        console.log(response);

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
                        console.log(response);

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
        //bookmark topic

        $('#bookmark-topic').click(function(e){
            e.preventDefault();

            const topicId = $(this).attr("bookmark-topic");
            console.log(topicId);
            $.ajax({
                url: '/bookmark/topic_message',
                type: 'POST',
                data: {
                    "_token" : "{{ csrf_token() }}",
                    'topic_id' : topicId,
                    'role' : 'topic',
                },
                success: function (response) {
                    console.log(response);
                    let content = "";

                    if(response.status === 200){
                        toastr.options =
                            {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                        toastr.success("topic bookmarked successfully");
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
