@if($messages->count() <= 0)
    <h5 class="text-secondary"><strong>No Topic Replies Be the first one to reply</strong></h5>
@else
    <h5 class="text-secondary"><strong>Topic Replies</strong></h5>

    <div>
        @foreach($messages as $t_message)
            <div class="single-topic-message">
                <div class="row col-md-12">
                    <div class="row col-md-12">
                        <div class="col-md-6">

                            <img style="margin-right: 10px; float: left" class="img-fluid" src="/profile_pictures/{{ $t_message->user->profile_url }}"
                                 alt="" width="70" height="60">

                            <h6>{{ \Carbon\Carbon::parse($t_message->created_at)->format('j M, `y') }}</h6>
                            <h6>
                                <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                   data-bs-placement="top" title="{{ $t_message->author }}" data-bs-content="
                                        Joined: {{ $t_message->user->joined_date  }}
                                    Level: {{ $t_message->user->level  }}
                                    Messages: {{ $t_message->where('author',$t_message->user->username)->count() }}
                                    ">
                                    <strong> {{ $t_message->author }} </strong>
                                </a>
                            </h6>

                        </div>
                        <div class="col-md-6">
                            @if(\Illuminate\Support\Facades\Auth::check())
                                <button style="float: right;" onclick="bookMark({{ $t_message->id }})"  class="btn btn-lg text-secondary disappear-item"
                                        id="{{$t_message->author}}" bookmark-message="{{ $t_message->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this topic">
                                    <i class="fa fa-bookmark"></i>
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
                                                document.getElementById('{{$t_message->author}}').disabled = true;
                                                document.getElementById('{{$t_message->author}}').className = 'btn btn-lg text-success disappear-item';
                                            }
                                        },

                                        failure: function (response) {
                                            console.log("something went wrong");
                                        }
                                    });
                                </script>
                            @endif

                        </div>
                    </div>

                </div>

                <hr style="color: lightgrey;">
                <p>{!! $t_message->body  !!}<a href="{{ route('site.single.message',$t_message->message_id) }}">Read</a></p>

                @include('site.topics.partials.topic_actions')

                <!---comments sections--->

              @include('site.topics.partials.topic_comments')

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

@endif
