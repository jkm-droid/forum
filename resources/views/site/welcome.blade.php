@extends('base.index')

@section('content')
    <p id="success-box" class="text-end fixed-top" style="margin-top: 60px; margin-right: 5px;"></p>

    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"></li>
        </ol>
    </nav>

    <section class="main-content">
        <div class="d-flex justify-content-center" >
            <a class="btn top-options text-primary" href="{{ route('site.forum.list') }}">Forum List</a>
            <a class="btn top-options text-danger" href="{{ route('site.top.topics') }}">Top Topics</a>
            <a class="btn top-options text-success" href="{{ route('topic.show.create.form') }}">
                <i class="fa fa-plus"></i> New Topic
            </a>
        </div>

        <div class="row mt-2">
            <div class="col-md-2 topic-creation-categories">
                @include('includes.member')
                @include('includes.forum_list')
            </div>

            <div class="col-md-10">
                @if(count($topics) > 0)
                    <h4>Latest Topics</h4>

                    <hr>

                    @foreach($topics as $topic)
                        <div class="row col-md-12">
                            <div class="col-md-8">
                                <img style="float: left; margin-right: 10px;" src="/profile_pictures/{{ $topic->user->profile_url }}"
                                     alt="" width="60" height="60">

                                <h6 class="latest-topic-content">
                                    <a class="put-black" id="{{ $topic->id }}" href="{{ route('site.single.topic', $topic->slug) }}">{{ $topic->title }}</a>
                                </h6>
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

                            <div class="col-md-2 text-start disappear-item">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <h6>Messages: </h6>
                                        </td>
                                        <td style="padding-left: 30px;">
                                            <h6><strong>{{ $topic->messages->count() }}</strong></h6>
                                        </td>
                                    </tr>
                                    <tr>
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

                            <div class="row col-md-2 disappear-item">
                                @foreach($topic->messages as $topic_message)
                                    @if($loop->last)

                                        <div class="col-md-8 text-end">
                                            <button class="btn text-secondary" style="padding: 0; font-size: medium;" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ \Carbon\Carbon::parse($topic_message->created_at)->format('j M, Y@H:m') }}">
                                                <small>{{ $topic_message->formatted_message_time }}</small>
                                            </button>

                                            <a  class="text-secondary" style="padding: 0; font-size: medium;"  data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                                data-bs-placement="top" title="{{ $topic_message->author }}" data-bs-content="
                                            Joined: {{ $topic_message->user->joined_date  }}
                                                Level: {{ $topic_message->user->level  }}
                                                Messages: {{ $topic_message->user->messages->count() }}
                                                ">
                                                <strong>
                                                    <small>
                                                        @if(\Illuminate\Support\Str::contains($topic_message->author,'.'))
                                                            {{ strtok($topic_message->author,'.') }}
                                                        @else
                                                            {{ $topic_message->author }}
                                                        @endif
                                                    </small>
                                                </strong>
                                            </a>
                                        </div>

                                        <div class="col-md-2 text-start">
                                            <img src="/profile_pictures/{{ $topic_message->user->profile_url }}"
                                                 alt="" width="40" height="45">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <hr style="color: #cec1c1;">
                    @endforeach

                    <div class="d-flex justify-content-center paginate-desktop">
                        {{ $topics->links() }}
                    </div>

                    <div class="d-flex justify-content-center paginate-mobile">
                        {{ $topics->links('pagination.custom_pagination') }}
                    </div>

                @else
                    @include('includes.alert')
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            Sorry..no topics were found
                        </div>
                    </div>
                @endif
            </div>

        </div>
        <script>
            function getTopicStatus(topicId){
                const id = $(this).attr("topic-id");
                console.log(id);
                document.getElementById(id)
                $(document).ready(function() {

                    console.log(topicId);
                    $.ajax({
                        url: '/view/status',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'topic_id': topicId,
                        },
                        success: function (response) {
                            console.log(response);
                        },

                        failure: function (response) {
                            console.log("something went wrong");
                        }
                    });
                });
            }
        </script>
    </section>
@endsection
