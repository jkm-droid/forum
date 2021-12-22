@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a  href="{{ route('site.forum.list') }}">Forum</a></li>
            <li class="breadcrumb-item active" aria-current="page">Top Topics</li>
        </ol>
    </nav>
    <section class="main-content">
        <div class="row">
            <div class="col-md-3 topic-creation-categories">
                @include('includes.short_forum_list')
            </div>
            <div class="col-md-9">
                <h4 class="top-topics-title">Top Topics</h4>
                <hr>
                <div class="row">
                    @foreach($top_topics as $top)

                        <div class="col-md-7" style="margin-bottom: 10px; ">
                            <h6>
                                <a href="{{ route('site.single.topic', $top->slug) }}">{{ $top->title }}</a>
                            </h6>
                            @if($top->tags->count() > 0)
                                @foreach($top->tags as $t_tag)
                                    <span class="badge bg-secondary">{{ $t_tag->title }}</span>
                                @endforeach
                            @endif
                        </div>
                        <div class="row col-md-5" >
                            <div class="col-md-4" >
                                <span style="font-weight: bold">{{ $top->messages->count() }}</span>
                                <small> Replies</small>

                                <span style="font-weight: bold; padding-left: 3px">{{ $top->views }}</span>
                                <small>Views</small>
                            </div>
                            <div class="col-md-8 profile">
                                <img style="float: left" class="disappear-item" src="/profile_pictures/{{ \App\Models\User::where('username', $top->author)->first()->profile_url }}" alt="" width="50" height="40">
                                <span style="font-weight: bold;">
                                    <a data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                       data-bs-placement="left" title="{{ $top->author }}" data-bs-content="
                                        Joined: {{ \App\Models\User::where('username', $top->author)->first()->joined_date  }}
                                        Level: {{ \App\Models\User::where('username', $top->author)->first()->level  }}
                                        Messages: {{ \App\Models\Message::where('author', $top->author)->count() }}
                                        ">
                                    <strong>{{ $top->author }}</strong>
                                </a>
                                </span>
                                <br>
                                <span class="text-secondary">
                                    <button style="padding: 0" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="{{ \Carbon\Carbon::parse($top->created_at)->format('j M, Y@H:m') }}">
                                    {{ \Carbon\Carbon::parse($top->created_at )->format('j M, Y')}}
                                </button>
                                </span>
                            </div>
                        </div>

                        <hr style="color: lightgrey">
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection
