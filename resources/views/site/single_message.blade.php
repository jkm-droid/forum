@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('site.top.topics') }}">Topics</a></li>
            <li class="breadcrumb-item">Messages</li>
            <li class="breadcrumb-item active" aria-current="page">{!! substr(strip_tags($message->body),0,20) !!}</li>
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

    <div class="container col-md-3">
        <table class="table table-borderless table-sm single-message-table text-center">
            <thead>
            <tr>
                <th>created</th>
                <th>
                    {{ $message->likes }}
                </th>
                <th>{{ $message->comments->count() }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <img src="/profile_pictures/{{ $message->user->profile_url }}"
                         alt="" width="17" height="17">
                    {{  \Carbon\Carbon::parse($message->created_at)->format('M, `y') }}
                </td>
                <td>likes</td>
                <td>comments</td>
            </tr>
            </tbody>
        </table>
        <div class="text-center">
            <div class="btn-group" role="group" id="{{ $message->id }}{{ $message->author }}" style="display: none;">
                <a data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" style="padding-left: 5px;"
                   title="Share this post" data-bs-content="{{ route('site.single.message', $message->message_id) }}">
                    <i class="fa fa-link"></i>
                </a>

                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('site.single.message', $message->message_id) }}&quote={{ \Illuminate\Support\Str::limit($message->body,'100','...') }}"
                   style="color: #0a53be; padding-left: 5px;">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ \Illuminate\Support\Str::limit($message->body,'100','...')  }}&url={{ route('site.single.message', $message->message_id) }}"
                   style="color: #0dcaf0; padding-left: 5px;">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="https://wa.me/?text=Awesome%20Blog!%5Cn%20blog.shahednasser.com"  class="text-success" style="padding-left: 5px">
                    <i class="fa fa-whatsapp"></i>
                </a>
                <a href="https://t.me/share/url?url={{ route('site.single.message', $message->message_id) }}&text={{ \Illuminate\Support\Str::limit($message->body,'100','...')  }}"
                   style="padding-left: 5px; padding-right: 5px" class="text-info">
                    <i class="fa fa-telegram"></i>
                </a>
            </div>

            <a id="btn_share_message" class="btn text-secondary" share-id="{{ $message->id }}{{ $message->author }}"
               data-bs-toggle="tooltip" data-bs-placement="left" title="share this post's link">
                <i class="fa fa-share-alt"></i> Share
            </a>

            <button class="btn  btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this message">
                <i class="fa fa-bookmark"></i>
            </button>

            <a href="#reply-editor" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment/message about this message">
                <i class="fa fa-reply"></i> Reply
            </a>
        </div>
    </div>

    <!-----comments sections--->
    @if(count($message->comments) > 0)
        <h4>Comments</h4>
        <div id="{{ $message->author }}" style="border-top: 1px solid #a7c2a7; padding: 5px; background-color: #e7e4e4;">

            @foreach($message->comments as $tm_comment)
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <img class="img-fluid" style="float: left; margin-right: 10px;" src="/profile_pictures/{{ $tm_comment->message->user->profile_url }}"
                             alt="" width="70" height="60">

                        <h6>
                            <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                               data-bs-placement="top" title="{{ $tm_comment->author }}" data-bs-content="
                                                    Joined: {{ $tm_comment->message->user->joined_date }}
                                Level: {{ $tm_comment->message->user->level  }}
                                Messages: {{  $message->where('author',$tm_comment->author)->count() }}
                                ">
                                <strong> <i class="fa fa-share"></i>  {{ $tm_comment->author }}</strong>
                            </a>
                        </h6>
                        <h6 class="">{{ \Carbon\Carbon::parse($tm_comment->created_at)->format('j M, Y') }}</h6>
                    </div>
                </div>
                <p>
                    {!! $tm_comment->body   !!}
                </p>
                @if(\Illuminate\Support\Facades\Auth::check())
                    @if($user->username == $tm_comment->author)
                        <span class="d-flex justify-content-end message-text">
                            <a href="{{ route('message.show.edit.reply.form',$tm_comment->comment_id) }}" class="text-secondary" data-bs-toggle="tooltip"
                               data-bs-placement="left" title="edit this reply">
                                <i class="fa fa-edit"></i> Edit
                            </a>

                            <button id="delete-comment-reply" data-id="{{ $tm_comment->id }}" class="btn text-secondary" data-bs-toggle="tooltip"
                                    data-bs-placement="left" title="delete this reply" style="padding: 0;margin-left: 10px; margin-right: 10px;">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </span>
                    @endif
                @endif
                <hr style="color: #544848;">
            @endforeach

        </div>

    @else
        <p>this thread has no comments</p>
    @endif

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

                            history.scrollRestoration = "manual";
                            $(this).scrollTop(0);
                            location.reload();
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
                            console.log(response);
                            history.scrollRestoration = "manual";
                            $(this).scrollTop(0);
                            location.reload();

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
                            history.scrollRestoration = "manual";
                            $(this).scrollTop(0);

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
                            location.reload();
                        },

                        failure: function (response) {
                            console.log("something went wrong");
                        }
                    });
                }
            });

        </script>

@endsection
