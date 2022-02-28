@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('site.top.topics') }}">Topics</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($topic->title, 20, "...") }}</li>
        </ol>
    </nav>
    <h4>{{ $topic->title }}</h4>
    {{ $topic->category->title }} |
    @foreach($topic->tags as $t_tag)
        <span class="text-white badge bg-danger">{{ $t_tag->title }}</span>
    @endforeach
    <br>
    <img src="/profile_pictures/{{\App\Models\User::where('username', $topic->author)->first()->profile_url }}" alt="" width="60" height="50">
    {{ $topic->author }}
    @if(\Illuminate\Support\Facades\Auth::check())
        @if(\Illuminate\Support\Facades\Auth::user()->username == $topic->author)

            <button style="padding: 0 0 0 2px" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this topic">
                <a href="{{ route('topic.show.edit.form', $topic->slug) }}"><i class="fa fa-edit"></i></a>
            </button>

            <button style="padding: 0 0 0 2px"  id="delete-topic" data-id="{{ $topic->id }}" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="delete this topic">
                <i class="fa fa-trash"></i>
            </button>
        @endif
    @endif

    <p class="topic-body">
        {!! $topic->body !!}
    </p>

    <div class="container col-md-3">
        <table class="table table-borderless table-sm single-topic-table text-center">
            <thead>
            <tr>
                <th>created</th>
                <th>
                    {{ $messages->sum('likes') }}
                </th>
                <th>{{ $topic->messages->count() }}</th>
                <th>{{ $topic->views }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <img src="/profile_pictures/{{\App\Models\User::where('username', $topic->author)->first()->profile_url }}"
                         alt="" width="17" height="17">
                    {{  \Carbon\Carbon::parse($topic->created_at)->format('M, `y') }}
                </td>
                <td>likes</td>
                <td>comments</td>
                <td>views</td>
            </tr>
            </tbody>
        </table>
        <div class="text-center">
            <button class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="share this topic's link">
                <i class="fa fa-link"></i>
            </button>

            <button class="btn  btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this topic">
                <i class="fa fa-bookmark"></i>
            </button>

            <a href="#reply-editor" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment/message about this topic">
                <i class="fa fa-reply"></i> Reply
            </a>
        </div>
    </div>
    @if($messages->count() <= 0)
        <h5 class="text-secondary"><strong>No Topic Replies Be the first one to reply</strong></h5>
    @else
        <h5 class="text-secondary"><strong>Topic Replies</strong></h5>

    <!------------messages section-------------->
    <div>
        @foreach($messages as $t_message)
            <div class="single-topic-message">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <img style="margin-right: 10px; float: left" class="img-fluid" src="/profile_pictures/{{\App\Models\User::where('username', $t_message->author)->first()->profile_url }}"
                             alt="" width="70" height="60">

                        <h6>{{ \Carbon\Carbon::parse($t_message->created_at)->format('j M, `y') }}</h6>
                        <h6>
                            <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                               data-bs-placement="top" title="{{ $t_message->author }}" data-bs-content="
                                        Joined: {{ $t_message->user->joined_date  }}
                                Level: {{ $t_message->user->level  }}
                                Messages: {{ $t_message->where('author', $t_message->author)->count() }}
                                ">
                                <strong> {{ $t_message->author }} </strong>
                            </a>
                        </h6>
                    </div>

                </div>

                <hr style="color: lightgrey;">
                <p>{!! $t_message->body  !!}</p>
                <div class="text-end action-buttons">
                    @if(\Illuminate\Support\Facades\Auth::check())
                        @if(\Illuminate\Support\Facades\Auth::user()->username == $t_message->author)

                            <button class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this reply">
                                <i class="fa fa-edit"></i> Edit
                            </button>

                            <button id="delete-reply" data-id="{{ $t_message->id }}" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="delete this reply">
                                <i class="fa fa-trash"></i> Delete
                            </button>

                        @endif
                    @endif

                    <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="like">
                        {{ $t_message->comments->count() }} Reactions
                    </button>

                    <div class="btn-group" role="group" id="{{ $t_message->id }}{{ $t_message->author }}" style="display: none;">
                        <a type="button" class="btn" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" title="Share this post" data-bs-content="{{ route('site.single.topic', $topic->slug) }}">
                            <i class="fa fa-link"></i>
                        </a>

                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('site.single.topic', $topic->slug) }}&quote={{ $topic->title }}" type="button" class="btn" style="color: #0a53be;">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ $topic->title }}&url={{ route('site.single.topic', $topic->slug) }}" type="button" class="btn" style="color: #0dcaf0;">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text=Awesome%20Blog!%5Cn%20blog.shahednasser.com" type="button" class="btn text-success">
                            <i class="fa fa-whatsapp"></i>
                        </a>
                        <a href="https://t.me/share/url?url={{ route('site.single.topic', $topic->slug) }}&text={{ $topic->title }}" type="button" class="btn text-info">
                            <i class="fa fa-telegram"></i>
                        </a>

                    </div>

                    <button id="btn_share_topic" class="btn text-secondary" share-id="{{ $t_message->id }}{{ $t_message->author }}" data-bs-toggle="tooltip" data-bs-placement="left" title="share this post's link">
                        <i class="fa fa-share-alt"></i> Share
                    </button>
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <button id="{{ $t_message->id }}"  class="btn text-secondary" data-bs-toggle="tooltip" like-id="{{ $t_message->id }}" like-author="{{ $t_message->author }}" data-bs-placement="left" title="like">
                            <span id="{{ $t_message->author }}{{ $t_message->id }}">{{ $t_message->likes }}</span> <i class="fa fa-heart"></i>
                        </button>

                        <script>
                            // function like(){
                                $(document).on('click', '#'+{{ $t_message->id }}, function(){
                                    const id = $(this).attr("like-id");
                                    const author = $(this).attr("like-author");
                                    const id_author = id+author;
                                    console.log(id_author);
                                    $.ajax({
                                        url: '/message/like',
                                        type: 'POST',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            'message_id': id,
                                        },
                                        success: function (response) {
                                            console.log(response.likeCount);
                                            if(response.status === 200){
                                                toastr.options =
                                                    {
                                                        "closeButton" : true,
                                                        "progressBar" : true
                                                    }
                                                toastr.success("Message Liked successfully");
                                                document.getElementById(id_author).innerHTML = response.likeCount;
                                            }
                                        },

                                        failure: function (response) {
                                            console.log("something went wrong");
                                        }
                                    });
                                });
                            // }
                        </script>
                        <button reply-id="{{ $t_message->id }}" reply-body="{!! $t_message->body !!}" id="btn_post_reply" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment">
                            <i class="fa fa-reply"></i> Reply
                        </button>
                    @else
                        <button class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="like">
                            {{ $t_message->likes }} <i class="fa fa-heart"></i>
                        </button>

                        <button class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this post">
                            <i class="fa fa-bookmark"></i>
                        </button>

                        <button  id="btn_post_reply" class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment">
                            <i class="fa fa-reply"></i> Reply
                        </button>
                    @endif
                </div>

                <!---comments sections--->
                @if($t_message->comments->count() > 0)
                    <div class="text-center">
                        <button id="btn_show_reactions" comment-id="{{ $t_message->author }}"   class="btn {{ $t_message->id }}" >view reactions</button>
                    </div>
                @endif

                <script>
                    // function showComment() {
                    $(document).on('click', '#btn_show_reactions', function () {
                        const id = $(this).attr("comment-id");
                        document.getElementById('btn_show_reactions').style.display = 'none';
                        document.getElementById(id).style.display = 'block';
                    });
                    // }
                </script>

                <div id="{{ $t_message->author }}" style="display: none; border-top: 1px solid #a7c2a7; padding: 5px; background-color: #e7e4e4;">
                    @if($t_message->comments)
                        @foreach($t_message->comments as $tm_comment)
                            <div class="row col-md-12">
                                <div class="col-md-12">
                                    <img class="img-fluid" style="float: left; margin-right: 10px;" src="/profile_pictures/{{\App\Models\User::where('username', $tm_comment->author)->first()->profile_url }}"
                                         alt="" width="70" height="60">

                                    <h6>
                                        <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                           data-bs-placement="top" title="{{ $tm_comment->author }}" data-bs-content="
                                                    Joined: {{ \App\Models\User::where('username', $tm_comment->author)->first()->joined_date  }}
                                            Level: {{ \App\Models\User::where('username', $tm_comment->author)->first()->level  }}
                                            Messages: {{ \App\Models\Message::where('author', $tm_comment->author)->count() }}
                                            ">
                                            <strong> <i class="fa fa-share"></i>  {{ $tm_comment->author }} says:</strong>
                                        </a>
                                    </h6>
                                    <h6 class="">{{ \Carbon\Carbon::parse($tm_comment->created_at)->format('j M, Y') }}</h6>
                                </div>
                            </div>
                            <p class="" style="">
                                {!! $tm_comment->body   !!}
                            </p>
                            <hr style="color: lightgrey;">
                        @endforeach
                    @endif
                </div>
                <!-----end comments sections--->
            </div>


        @endforeach
            <div class="d-flex justify-content-center paginate-desktop">
                {{ $messages->links() }}
            </div>

            <div class="d-flex justify-content-center paginate-mobile">
                {{ $messages->links('pagination.custom_pagination') }}
            </div>
    </div>
    <!------------end messages section-------------->
    @endif
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
    {{--        </div>--}}
    {{--    </div>--}}


    <script>
        $(document).on('click', '#btn_share_topic', function () {
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
                    url: '/post/reply/',
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
                let content = '<small class="text-center put-red">' + "Error!Email cannot be empty" + '</small>';
                $("#message-box").html(content);
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

                        history.scrollRestoration = "manual";
                        $(this).scrollTop(0);
                        location.reload();
                    },

                    failure: function (response) {
                        console.log("something went wrong");
                    }
                });
            }else{
                let content = '<small class="text-center put-red">' + "Error!Email cannot be empty" + '</small>';
                $("#message-box").html(content);
            }
        });

    </script>

    <script type="text/javascript">

        $(document).on('click', '#delete-reply',function(e) {
            // e.preventDefault();

            if (confirm("Are you sure want to delete this reply?")) {

                const replyId = $(this).attr("data-id");

                $.ajax({
                    url: '/reply/delete',
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
@endsection
