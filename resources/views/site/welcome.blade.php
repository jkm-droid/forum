@extends('base.index')

@section('content')
    <p id="success-box" class="text-end fixed-top" style="margin-top: 60px; margin-right: 5px;"></p>
    <section class="main-content">
        <div class="text-center">
            <a class="btn top-options" href="{{ route('site.all.categories') }}">All Categories</a>
            <a class="btn top-options" href="{{ route('site.top.topics') }}">Top Topics</a>
            <a class="btn top-options" href="{{ route('site.show.topic.form') }}">
                <i class="fa fa-plus"></i> New Topic
            </a>
        </div>

        <div class="row">
            <div class="col-md-3 topic-creation-categories">
                @include('includes/category')
            </div>
            <div class="col-md-9">
                <h4>Latest Topics</h4><hr>
                @foreach($topics as $topic)
                    <div class="row">
                        <div class="col-md-8">
                            <img style="float: left;" src="/profile_pictures/{{\App\Models\User::where('username', $topic->author)->first()->profile_url }}"
                                 alt="" width="60" height="50">
                            <h5 class="latest-topic-content">
                                <a class="put-black" href="{{ route('site.single.topic', $topic->slug) }}">{{ $topic->title }}</a>
                            </h5>
                            <h5 class="latest-topic-content text-secondary">
                                <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                   data-bs-placement="top" title="{{ $topic->author }}" data-bs-content="
                                        Joined: {{ \App\Models\User::where('username', $topic->author)->first()->joined_date  }}
                                    Level: {{ \App\Models\User::where('username', $topic->author)->first()->level  }}
                                    Messages: {{ \App\Models\Message::where('author', $topic->author)->count() }}
                                    ">
                                    <strong>{{ $topic->author }}</strong>
                                </a>
                                <span style="margin-left: 5px;"></span> {{  \Carbon\Carbon::parse($topic->created_at)->format('j M, y') }}
                                <button class="btn "><i class="fa fa-thumbs-up"></i> {{ $topic->messages->sum('likes') }}</button>
                            </h5>
                            @if($topic->tags->count() > 0)
                                <span class="latest-topic-content">
                                @foreach($topic->tags as $topic_tag)
                                        <span class="badge bg-success">{{ $topic_tag->title }}</span>
                                    @endforeach
                                </span>
                            @endif
                            <br>
                            @if(\Illuminate\Support\Facades\Auth::check())
                                @if(\Illuminate\Support\Facades\Auth::user()->username == $topic->author)
                                    <div class="user-actions">
                                        <button class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="edit this topic">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>

                                        <button id="delete-topic" data-id="{{ $topic->id }}" class="btn btn-lg text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="delete this topic">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="col-md-2">
                            <table>
                                <tbody>
                                <tr class="change-padding">
                                    <td>
                                        <h6>Messages: </h6>
                                    </td>
                                    <td style="padding-left: 30px;">
                                        <h6><strong>{{ $topic->messages->count() }}</strong></h6>
                                    </td>
                                </tr>
                                <tr class="disappear-item">
                                    <td>
                                        <h6>Views:</h6>
                                    </td>
                                    <td style="padding-left: 30px;">
                                        <strong>{{ $topic->views }}</strong>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2 moments-ago-section">
                            <h5 class="disappear-item">
                                {{ $topic->formatted_topic_time }}
                            </h5>
                            <h5 class="disappear-item">
                                @foreach($topic->messages as $topic_message)
                                    @if($loop->first)
                                        <img src="/profile_pictures/{{\App\Models\User::where('username', $topic_message->author)->first()->profile_url }}"
                                             alt="" width="35" height="30">
                                        <a  class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                            data-bs-placement="top" title="{{ $topic_message->author }}" data-bs-content="
                                            Joined: {{ \App\Models\User::where('username', $topic_message->author)->first()->joined_date  }}
                                            Level: {{ \App\Models\User::where('username', $topic_message->author)->first()->level  }}
                                            Messages: {{ \App\Models\Message::where('author', $topic_message->author)->count() }}
                                            ">
                                            <strong> {{ $topic_message->author }}</strong>
                                        </a>
                                    @endif
                                @endforeach

                            </h5>

                        </div>
                    </div>

                    <hr style="color: lightgrey;">
                @endforeach
                <div class="d-flex justify-content-center">
                    {!! $topics->links() !!}
                </div>
            </div>

        </div>
        <script>
            $(document).ready(function() {
                var image = '<img src="https://developer.chrome.com/extensions/examples/api/idle/idle_simple/sample-128.png">';
                $('[data-toggle="popover"]').popover({
                    html:true
                });
            });
        </script>
    </section>
@endsection
