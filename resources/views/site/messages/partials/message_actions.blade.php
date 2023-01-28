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

            {{--                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('site.single.message', $message->message_id) }}&quote={{ \Illuminate\Support\Str::limit($message->body,'100','...') }}"--}}
            {{--                   style="color: #0a53be; padding-left: 5px;">--}}
            {{--                    <i class="fa fa-facebook"></i>--}}
            {{--                </a>--}}
            {{--                --}}
            {{--                <a href="https://twitter.com/intent/tweet?text={{ \Illuminate\Support\Str::limit($message->body,'100','...')  }}&url={{ route('site.single.message', $message->message_id) }}"--}}
            {{--                   style="color: #0dcaf0; padding-left: 5px;">--}}
            {{--                    <i class="fa fa-twitter"></i>--}}
            {{--                </a>--}}
            <a href="https://wa.me/?text=Awesome%20Blog!%5Cn%20blog.shahednasser.com"  class="text-success" style="padding-left: 5px">
                <i class="fa fa-whatsapp"></i>
            </a>
            {{--                <a href="https://t.me/share/url?url={{ route('site.single.message', $message->message_id) }}&text={{ \Illuminate\Support\Str::limit($message->body,'100','...')  }}"--}}
            {{--                   style="padding-left: 5px; padding-right: 5px" class="text-info">--}}
            {{--                    <i class="fa fa-telegram"></i>--}}
            {{--                </a>--}}
        </div>

        <a id="btn_share_message" class="btn text-secondary" share-id="{{ $message->id }}{{ $message->author }}"
           data-bs-toggle="tooltip" data-bs-placement="left" title="share this post's link">
            <i class="fa fa-share-alt"></i> Share
        </a>

        <button onclick="bookMark({{ $message->id }})"  class="btn text-secondary"
                id="{{$message->message_id}}" bookmark-message="{{ $message->id }}"
                data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this message">
            <i class="fa fa-bookmark"></i><span style="font-size:medium" id="bookmark-status">Save</span>
        </button>

        <script type="text/javascript">
            $.ajax({
                url: '/bookmark/status',
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'message_id': {{ $message->id }},
                    'role' : 'message'
                },
                success: function (response) {
                    console.log(response);
                    if(response.message === "bookmarked"){
                        document.getElementById('{{ $message->message_id }}').disabled = true;
                        document.getElementById('{{ $message->message_id }}').className = 'btn text-success';
                        document.getElementById('bookmark-status').innerText = 'Saved';
                    }
                },

                failure: function (response) {
                    console.log("something went wrong");
                }
            });
        </script>

        <a href="#reply-editor" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment/message about this message">
            <i class="fa fa-reply"></i> Reply
        </a>
    </div>
</div>
