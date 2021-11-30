@extends('base.index')

@section('content')
    <h4>{{ $topic->title }}</h4>
    {{ $topic->category->title }} |
    @foreach($topic->tags as $t_tag)
        <span class="text-white badge bg-danger">{{ $t_tag->title }}</span>
    @endforeach
    <br>
    <img src="/profile_pictures/{{\App\Models\User::where('username', $topic->author)->first()->profile_url }}" alt="" width="60" height="50">
    {{ $topic->author }}

    <p class="topic-body">
        {{ $topic->body }}
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

    <h5 class="text-secondary"><strong>Topic Replies</strong></h5>

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
                <p class="message-padding">{{ $t_message->body }}</p>
                <div class="text-end">
                    <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="like">
                        {{ $t_message->comments->count() }} Reactions
                    </button>

                    <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="like">
                        {{ $t_message->likes }} <i class="fa fa-heart"></i>
                    </button>

                    <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="share this post's link">
                        <i class="fa fa-link"></i>
                    </button>

                    <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this post">
                        <i class="fa fa-bookmark"></i>
                    </button>

                    <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment">
                        <i class="fa fa-reply"></i> Reply
                    </button>
                </div>
                @if($t_message->comments->count() > 0)
                    <div class="text-center">
                        <button id="btn_show_reactions"  class="btn" >view reactions</button>
                    </div>
                @endif

                <!---comments sections--->
                <div id="message_reactions" style="display: none;">
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

                <script>

                    $(document).on('click', '#btn_show_reactions', function(){
                        $('#message_reactions').show();
                    });

                </script>
                <!-----end comments sections--->
            </div>


        @endforeach
    </div>
    <!------------end messages section-------------->
    <div class="" id="reply-editor">
        @if(\Illuminate\Support\Facades\Auth::check())

            <form>
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
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>--}}
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
                        document.getElementById("subscribe-form").reset();

                        if(response.status === 200){
                            content = '<small class="text-center put-green">' + "Message sent successfully.We will reach you through your email." + '</small>';
                        }else if(response.status === 202){
                            content = '<small class="text-center put-red">' + response.message['email'] + '</small>';
                        }else{
                            content = '<small class="text-center put-red">' + "Oops! An error occurred." + '</small>';
                        }

                        $("#message-box").html(content);

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
@endsection
