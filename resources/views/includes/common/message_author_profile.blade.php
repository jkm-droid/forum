<div class="row col-md-2 disappear-item">
    @foreach($topic->messages as $topic_message)
        @if($loop->last)

            <div class="col-md-8 text-end">
                <button class="btn text-secondary" style="padding: 0; font-size: medium;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ \Carbon\Carbon::parse($topic_message->created_at)->format('j M, Y@H:m') }}">
                    <small>{{ $topic_message->formatted_message_time }}</small>
                </button>
                <br>
                <a  class="text-secondary" style="padding: 0; font-size: medium;"  data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                    data-bs-placement="top" title="{{ $topic_message->author }}" data-bs-content="
                                            Joined: {{ $topic_message->user->joined_date  }}
                    Level: {{ $topic_message->user->level  }}
                    Messages: {{ $topic_message->where('author', $topic_message->author)->count() }}
                    ">
                    <strong><small>
                            @if(\Illuminate\Support\Str::contains($topic_message->author,'.'))
                                {{ strtok($topic_message->author,'.') }}
                            @else
                                {{ $topic_message->author }}
                            @endif
                        </small></strong>
                </a>
            </div>

            <div class="col-md-2 text-start">
                <img src="/profile_pictures/{{ $topic_message->user->profile_url }}"
                     alt="" width="40" height="45">
            </div>
        @endif
    @endforeach
</div>
