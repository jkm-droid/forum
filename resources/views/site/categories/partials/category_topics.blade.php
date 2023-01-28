<div class="col-md-8">
    <img style="float: left; margin-right: 10px;" src="/profile_pictures/{{ $topic->user->profile_url }}"
         alt="" width="60" height="60">

    <h6 class="latest-topic-content">
        <a class="put-black" id="{{ $topic->id }}" href="{{ route('site.single.topic', $topic->slug) }}">{{ $topic->title }}</a>
    </h6>

    <h6 class="latest-topic-content text-secondary" style="padding: 0 0 0 0;">
        <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
           data-bs-placement="top" title="{{ $topic->author }}" data-bs-content="
                                        Joined: {{ $topic->user->joined_date  }}
            Level: {{ $topic->user->level  }}
            Messages: {{ $topic->where('author', $topic->author)->count() }}
            ">
            <strong class="topic-text">{{ $topic->author }}</strong>
        </a>
        <span style="margin-left: 5px;" class="topic-text"> {{  \Carbon\Carbon::parse($topic->created_at)->format('j M, y') }}</span>

        <span style="padding: 0 0 0 2px" class="btn topic-text">
                                    <span class="disappear-item"><i class="fa fa-thumbs-up ml-2"></i>
                                        {{ \App\Models\Category::thousandsCurrencyFormat($topic->messages->sum('likes') )}}
                                        </span>
                                     <span class="show-on-mobile"><i class="fa fa-eye ml-2"></i> {{ $topic->views }}</span>
                                    <i class="fa fa-comments ml-2"></i> {{ $topic->messages->count() }}
                                </span>
    </h6>

    @if($topic->tags->count() > 0)
        <span class="latest-topic-content" style="margin-left: 20px;">
                                @foreach($topic->tags as $topic_tag)
                <span class="badge bg-success" style="padding: 3px">{{ $topic_tag->title }}</span>
            @endforeach
                                </span>
    @endif

    @if(\Illuminate\Support\Facades\Auth::check())
        @if($user->username == $topic->author)
            <div class="user-actions">
                <a href="{{ route('topic.show.edit.form', $topic->slug) }}" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this topic">
                    <i class="fa fa-edit"></i> Edit
                </a>

                <button id="delete-topic" data-id="{{ $topic->id }}" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="delete this topic">
                    <i class="fa fa-trash"></i> Delete
                </button>
            </div>
        @endif
    @endif
</div>
