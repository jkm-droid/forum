<div class="text-end action-buttons">
    @if(\Illuminate\Support\Facades\Auth::check())
        @if($user->username == $t_message->author)

            <a class="text-secondary" href="{{ route('message.show.edit.form', $t_message->message_id) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this reply">
                <i class="fa fa-edit"></i> edit
            </a>

            <button id="delete-message" data-id="{{ $t_message->id }}" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="delete this reply">
                <i class="fa fa-trash"></i> delete
            </button>

        @endif
    @endif

    <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="message reactions">
        {{ $t_message->comments->count() }} <i class="fa fa-comment"></i><span class="disappear-item">reactions</span>
    </button>

    <div class="btn-group" role="group" id="{{ $t_message->id }}{{ $t_message->author }}" style="display: none;">
        <a data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" style="padding-left: 5px;"
           title="Share this post" data-bs-content="{{ route('site.single.message', $t_message->message_id) }}">
            <i class="fa fa-link"></i>
        </a>

        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('site.single.message', $t_message->message_id) }}&quote={{ $topic->title }}"
           style="color: #0a53be; padding-left: 5px;">
            <i class="fa fa-facebook"></i>
        </a>
        {{--                            <a href="https://twitter.com/intent/tweet?text={{ \Illuminate\Support\Str::limit($t_message->body,'100','...') }}&url={{ route('site.single.message', $t_message->message_id) }}"--}}
        {{--                               style="color: #0dcaf0; padding-left: 5px;">--}}
        {{--                                <i class="fa fa-twitter"></i>--}}
        {{--                            </a>--}}
        <a href="https://wa.me/?text=Awesome%20Blog!%5Cn%20blog.shahednasser.com"  class="text-success" style="padding-left: 5px">
            <i class="fa fa-whatsapp"></i>
        </a>
        {{--                            <a href="https://t.me/share/url?url={{ route('site.single.message', $t_message->message_id) }}&text={{ \Illuminate\Support\Str::limit($t_message->body,'100','...')  }}"--}}
        {{--                               style="padding-left: 5px; padding-right: 5px" class="text-info">--}}
        {{--                                <i class="fa fa-telegram"></i>--}}
        {{--                            </a>--}}

    </div>

    <a id="btn_share_message" class="btn text-secondary" share-id="{{ $t_message->id }}{{ $t_message->author }}"
       data-bs-toggle="tooltip" data-bs-placement="left" title="share this post's link">
        <i class="fa fa-share-alt"></i> <span class="disappear-item">share</span>
    </a>
    @if(\Illuminate\Support\Facades\Auth::check())
        <button id="{{ $t_message->id }}"  class="btn text-secondary" data-bs-toggle="tooltip" like-id="{{ $t_message->id }}"
                like-author="{{ $t_message->author }}" data-bs-placement="left" title="message likes">
            <span id="{{ $t_message->author }}{{ $t_message->id }}">{{ $t_message->likes }}</span>
            <i class="fa fa-heart"></i><span class="disappear-item">likes</span>
        </button>

        <script>
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
                        if(response.status === 200){
                            toastr.options =
                                {
                                    "closeButton" : true,
                                    "progressBar" : true
                                }
                            toastr.success("Message Liked successfully");
                            document.getElementById(id_author).innerHTML = response.likeCount;
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

        <button style="display: none;" onclick="bookMark({{ $t_message->id }})"  class="btn text-secondary show-on-mobile"
                id="{{$t_message->message_id}}" bookmark-message="{{ $t_message->id }}"
                data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this message">
            <i class="fa fa-bookmark"></i><span class="disappear-item">save</span>
        </button>

        <script type="text/javascript">
            $.ajax({
                url: '/bookmark/status',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'message_id': {{ $t_message->id }},
                    'role' : 'message'
                },
                success: function (response) {
                    console.log(response);
                    if(response.message === "bookmarked"){
                        document.getElementById('{{ $t_message->message_id }}').disabled = true;
                        document.getElementById('{{ $t_message->message_id }}').className = 'btn text-success show-on-mobile';
                    }
                },

                failure: function (response) {
                    console.log("something went wrong");
                }
            });
        </script>

        <button reply-id="{{ $t_message->id }}" reply-body="{!! $t_message->body !!}" id="btn_post_reply" class="btn text-secondary"
                data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment">
            <i class="fa fa-reply"></i> Reply
        </button>
    @else
        <button class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="like">
            {{ $t_message->likes }} <i class="fa fa-heart"></i><span class="disappear-item">likes</span>
        </button>

        <button class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this post">
            <i class="fa fa-bookmark"></i><span class="disappear-item">save</span>
        </button>

        <button  id="btn_post_reply" class="btn text-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment">
            <i class="fa fa-reply"></i> Reply
        </button>
    @endif
</div>
