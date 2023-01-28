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
