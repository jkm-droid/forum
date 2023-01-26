@foreach($topics as $topic)
    <div class="row col-md-12">
        <div class="col-md-8">
            <img style="float: left; margin-right: 10px;" src="/profile_pictures/{{ $topic->user->profile_url }}"
                 alt="" width="60" height="60">

            <h6 class="latest-topic-content">
                <a class="put-black" id="{{ $topic->id }}" href="{{ route('site.single.topic', $topic->slug) }}">{{ $topic->title }}</a>
            </h6>
            @if(\Illuminate\Support\Facades\Auth::check())
                <script type="text/javascript">
                    $.ajax({
                        url: '/view/status',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'topic_id': {{ $topic->id }},
                        },
                        success: function (response) {
                            if(response.message === "viewed"){
                                document.getElementById({{ $topic->id }}).style.color = 'blue';
                            }else{
                                document.getElementById({{ $topic->id }}).style.fontWeight = 'bold';
                            }
                        },

                        failure: function (response) {
                            console.log("something went wrong");
                        }
                    });
                </script>
            @endif

            <h6 class="latest-topic-content text-secondary" style="padding: 0 0 0 0;">
                <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                   data-bs-placement="top" title="{{ $topic->author }}" data-bs-content="
                                        Joined: {{ $topic->user->joined_date  }}
                    Level: {{ $topic->user->level  }}
                    Messages: {{ $topic->user->topics->count() }}
                    ">
                    <strong class="topic-text">{{ $topic->author }}</strong>
                </a>
                <span style="margin-left: 5px;" class="topic-text"> {{  \Carbon\Carbon::parse($topic->created_at)->format('j M, y') }}</span>

                <span style="padding: 0 0 0 2px" class="btn topic-text">
                                    <i class="fa fa-thumbs-up ml-2"></i> {{ \App\Models\Category::thousandsCurrencyFormat($topic->messages->sum('likes') )}}
                                    <i class="fa fa-comments ml-2"></i> {{ $topic->messages->count() }}
                                </span>

            </h6>
            @if($topic->tags->count() > 0)
                <span class="latest-topic-content" style="margin-left: 20px;">
                                    @foreach($topic->tags as $topic_tag)
                        <small>
                                            <span class="badge bg-success" style="padding: 3px;">{{ $topic_tag->title }}</span>
                                        </small>
                    @endforeach
                                </span>
            @endif

            @if(\Illuminate\Support\Facades\Auth::check())
                @if($user->username == $topic->author)
                    <div class="user-actions">
                        <a href="{{ route('topic.show.edit.form', $topic->topic_id) }}" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this topic">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <button id="delete-topic" data-id="{{ $topic->id }}" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="delete this topic">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                @endif
            @endif
        </div>

        @include('includes.common.message_view_count')

        @include('includes.common.message_author_profile')

    </div>

    <hr style="color: #cec1c1;">
@endforeach
