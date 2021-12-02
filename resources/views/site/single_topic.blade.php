@extends('base.index')

@section('content')
    <p id="success-box" class="text-end fixed-top" style="margin-top: 60px; margin-right: 5px;"></p>
    <h4>{{ $topic->title }}</h4>
    {{ $topic->category->title }} |
    @foreach($topic->tags as $t_tag)
        <span class="text-white badge bg-danger">{{ $t_tag->title }}</span>
    @endforeach
    <br>
    <img src="/profile_pictures/{{\App\Models\User::where('username', $topic->author)->first()->profile_url }}" alt="" width="60" height="50">
    {{ $topic->author }}

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
                         alt="" width="20" height="17">
                    {{  \Carbon\Carbon::parse($topic->created_at)->format('M, y') }}
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
    @endif

    <!------------messages section-------------->
    <div>
        @foreach($messages as $t_message)
            <div class="single-topic-message">
                <img style="float: left" src="/profile_pictures/{{\App\Models\User::where('username', $t_message->author)->first()->profile_url }}"
                     alt="" width="70" height="60">

                <h6 class="">{{ \Carbon\Carbon::parse($t_message->created_at)->format('j M, y') }}</h6>
                <h6 class="message-padding">
                    <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                       data-bs-placement="top" title="{{ $t_message->author }}" data-bs-content="
                         Joined: {{ \App\Models\User::where('username', $t_message->author)->first()->joined_date  }}
                        Level: {{ \App\Models\User::where('username', $t_message->author)->first()->level  }}
                        Messages: {{ \App\Models\Message::where('author', $t_message->author)->count() }}
                        ">
                        <strong> {{ $t_message->author }} </strong>
                    </a>
                </h6>
                <hr style="color: lightgrey;">
                <p class="message-padding">{!! $t_message->body  !!}</p>
                <div class="text-end">
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

                    <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="share this post's link">
                        <i class="fa fa-link"></i>
                    </button>
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="like">
                            {{ $t_message->likes }} <i class="fa fa-heart"></i>
                        </button>

                        <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this post">
                            <i class="fa fa-bookmark"></i>
                        </button>

                        <button reply-id="{{ $t_message->id }}" id="btn_post_reply" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment">
                            <i class="fa fa-reply"></i> Reply
                        </button>
                    @else
                        <button class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="like">
                            {{ $t_message->likes }} <i class="fa fa-heart"></i>
                        </button>

                        <button class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this post">
                            <i class="fa fa-bookmark"></i>
                        </button>

                        <button reply-id="{{ $t_message->id }}" id="btn_post_reply" class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment">
                            <i class="fa fa-reply"></i> Reply
                        </button>
                    @endif
                </div>

                <!---reply form sections--->
                <div class="reply-form" id="{{ $t_message->id }}" style="display: none; margin-top: 10px;">
                    <form id="message-form" >
                        <textarea class="form-control summernote" name="body" id="reply-body-{{ $t_message->id }}" reply-body-id="{{ $t_message->id }}" rows="4"></textarea>

                        <div class="text-end" style="margin-top: 5px;">
                            <button type="submit" class="btn btn-warning" id="reply_button" reply-id="{{ $t_message->id }}">
                                <i class="fa fa-reply"></i> Post Reply
                            </button>
                        </div>
                    </form>
                </div>

                <!---end reply form sections--->

                <!---comments sections--->
                @if($t_message->comments->count() > 0)
                    <div class="text-center">
                        <button id="btn_show_reactions" comment-id="{{ $t_message->author }}"   class="btn {{ $t_message->id }}" >view reactions</button>
                    </div>
                @endif

                <div id="{{ $t_message->author }}" style="display: none;">
                    @if($t_message->comments)
                        @foreach($t_message->comments as $tm_comment)
                            <img style="float: left" src="/profile_pictures/{{\App\Models\User::where('username', $tm_comment->author)->first()->profile_url }}"
                                 alt="" width="70" height="60">

                            <h6 class="message-padding">
                                <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                   data-bs-placement="top" title="{{ $tm_comment->author }}" data-bs-content="
                                    Joined: {{ \App\Models\User::where('username', $tm_comment->author)->first()->joined_date  }}
                                    Level: {{ \App\Models\User::where('username', $tm_comment->author)->first()->level  }}
                                    Messages: {{ \App\Models\Message::where('author', $tm_comment->author)->count() }}
                                    ">
                                    <strong> <i class="fa fa-share"></i>  {{ $tm_comment->author }} says:</strong>
                                </a>
                            </h6>
                            <h6 class="">{{ \Carbon\Carbon::parse($tm_comment->created_at)->format('j M, y') }}</h6>
                            <p class="message-padding">
                                {{ $tm_comment->body }}
                            </p>
                        @endforeach
                    @endif
                </div>
                <!-----end comments sections--->
            </div>


        @endforeach
        <div class="d-flex justify-content-center" style="margin-top: 15px;">
            {!! $messages->links() !!}
        </div>
    </div>
    <!------------end messages section-------------->

    <div class="" id="reply-editor">
        <p id="message-error-box"></p>
        @if(\Illuminate\Support\Facades\Auth::check())
            <h4>write a reply this topic...</h4>
            <form id="message-form">
                <textarea class="form-control summernote" name="body" id="body" rows="4"></textarea>
                <input type="hidden" id="topic_id" value="{{ $topic->id }}">

                <div class="text-end">
                    <button type="submit" class="btn btn-warning" id="reply-button">
                        <i class="fa fa-reply"></i> Post Reply
                    </button>
                </div>
            </form>

        @else
            <h4 class="text-center put-red">you should have an account to reply in this section
                <a href="{{ route('show.register') }}">create one</a>
            </h4>
        @endif
    </div>
    <script>
        $(document).on('click', '#btn_show_reactions', function(){
            const id = $(this).attr("comment-id");
            // document.getElementById('btn_show_reactions').style.display = 'none';
            // console.log(document.getElementById(id));
            document.getElementById(id).style.display = 'block';
        });

    </script>

    <script>
        $(document).on('click', '#btn_post_reply', function(){
            const id = $(this).attr("reply-id");
            // console.log(id);
            // console.log(document.getElementById(id));
            document.getElementById(id).style.display = 'block';
        });
    </script>

    <script type="text/javascript">
        const inputBody = document.getElementById('body');
        const btn = document.getElementById('reply-button');

        inputBody.addEventListener('input', function (){
            btn.disabled = (this.value === '');
        });

        $('#reply-button').click(function(e){
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
                            content = '<small class="text-center put-green">' + "Reply saved successfully." + '</small>';
                        }else if(response.status === 202){
                            content = '<small class="text-center put-red">' + response.message['email'] + '</small>';
                        }else{
                            content = '<small class="text-center put-red">' + "Oops! An error occurred." + '</small>';
                        }

                        $("#success-box").html(content);

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
    <script>
        $('.reply-form').on('click', '#reply_button',function(e) {
            e.preventDefault();
            const topicId = $(this).attr("reply-id");
            // const replyBody = $('#reply-body-' + topicId).val();
            const replyBody = $(this).attr(" reply-body-id");

            if(replyBody !== "" ) {

                $.ajax({
                    url: '/post/reply/',
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
                            content = '<small class="text-center put-green">' + "Reply saved successfully." + '</small>';
                            // location.reload();
                            // $(window).scrollTop(0);
                        }else if(response.status === 202){
                            content = '<small class="text-center put-red">' + response.message['email'] + '</small>';
                        }else{
                            content = '<small class="text-center put-red">' + "Oops! An error occurred." + '</small>';
                        }

                        $("#success-box").html(content);

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
                        let content = "";
                        if (response.status === 200) {
                            content = '<small class="text-center put-green">' + "Reply deleted successfully." + '</small>';
                            location.reload();
                        } else if (response.status === 202) {
                            content = '<small class="text-center put-red">' + response.message['email'] + '</small>';
                        } else {
                            content = '<small class="text-center put-red">' + "Oops! An error occurred." + '</small>';
                        }

                        $("#success-box").html(content);

                    },

                    failure: function (response) {
                        console.log("something went wrong");
                    }
                });
            }
        });

    </script>
@endsection
