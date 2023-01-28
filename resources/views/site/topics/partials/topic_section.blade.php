<h4>{{ $topic->title }}</h4>
{{ $topic->category->title }}
@if(count($topic->tags) > 0)
    |
    @foreach($topic->tags as $t_tag)
        <span class="text-white badge bg-danger">{{ $t_tag->title }}</span>
    @endforeach
@endif
<br>
<img src="/profile_pictures/{{ $topic->user->profile_url }}" alt="" width="60" height="50">
<a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
   data-bs-placement="top" title="{{ $topic->author }}" data-bs-content="
                                        Joined: {{ $topic->user->joined_date  }}
    Level: {{ $topic->user->level  }}
    Messages: {{ $topic->user->topics->count() }}
    ">
    <strong> {{ $topic->author }} </strong>
</a>
@if(\Illuminate\Support\Facades\Auth::check())
    @if($user->username == $topic->author)

        <button style="padding: 0 0 0 2px" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this topic">
            <a href="{{ route('topic.show.edit.form', $topic->topic_id) }}"><i class="fa fa-edit"></i></a>
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
                <img src="/profile_pictures/{{ $topic->user->profile_url }}"
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
        <div class="btn-group" role="group" id="{{ $topic->id }}{{ $topic->author }}" style="display: none;">
            <a data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" style="padding-left: 5px;"
               title="Share this post" data-bs-content="{{ route('site.single.topic', $topic->slug) }}">
                <i class="fa fa-link"></i>
            </a>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('site.single.topic', $topic->slug) }}&quote={{ $topic->title }}"
               style="color: #0a53be; padding-left: 5px;">
                <i class="fa fa-facebook"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?text={{ $topic->title }}&url={{ route('site.single.topic', $topic->slug) }}"
               style="color: #0dcaf0; padding-left: 5px;">
                <i class="fa fa-twitter"></i>
            </a>
            <a href="https://wa.me/?text=Awesome%20Blog!%5Cn%20blog.shahednasser.com"  class="text-success" style="padding-left: 5px">
                <i class="fa fa-whatsapp"></i>
            </a>
            <a href="https://t.me/share/url?url={{ route('site.single.topic', $topic->slug) }}&text={{ $topic->title }}"
               style="padding-left: 5px; padding-right: 5px" class="text-info">
                <i class="fa fa-telegram"></i>
            </a>
        </div>

        <a id="btn_share_topic" class="btn text-secondary" share-id="{{ $topic->id }}{{ $topic->author }}"
           data-bs-toggle="tooltip" data-bs-placement="left" title="share this post's link">
            <i class="fa fa-share-alt"></i> Share
        </a>
        @if(\Illuminate\Support\Facades\Auth::check())
            <button class="btn text-secondary" id="bookmark-topic" bookmark-topic="{{ $topic->id }}" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this topic">
                <i class="fa fa-bookmark"></i><span style="font-size:medium" id="bookmark-status">Save</span>
            </button>
            <script type="text/javascript">
                $.ajax({
                    url: '/bookmark/status',
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'topic_id': {{ $topic->id }},
                        'role' : 'topic'
                    },
                    success: function (response) {
                        console.log(response);
                        if(response.message === "bookmarked"){
                            document.getElementById('bookmark-topic').disabled = true;
                            document.getElementById('bookmark-topic').className = 'btn  btn-lg text-success';
                            document.getElementById('bookmark-status').innerText = 'Saved';
                        }
                    },

                    failure: function (response) {
                        console.log("something went wrong");
                    }
                });
            </script>
        @endif
        <a href="#reply-editor" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment/message about this topic">
            <i class="fa fa-reply"></i> Reply
        </a>
    </div>
</div>
