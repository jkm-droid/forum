@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a  href="{{ route('site.forum.list') }}">Forum</a></li>
            <li class="breadcrumb-item active" aria-current="page">Top Topics</li>
        </ol>
    </nav>
    <section class="main-content">
        <div class="row">
            <div class="col-md-3 topic-creation-categories">
                @include('includes.member')
                @include('includes.forum_list')
            </div>
            <div class="col-md-9">
                @if(count($top_topics) > 0)
                    <h4 class="top-topics-title">Top Topics</h4>
                    <hr>

                    @foreach($top_topics as $top)
                        <div class="row">
                            <div class="col-md-7" style="margin-bottom: 10px; ">
                                <h6 style="padding: 0">
                                    <a href="{{ route('site.single.topic', $top->slug) }}">{{ $top->title }}</a>
                                </h6>
                                <span class="show-on-mobile topic-text">
                                <img src="/profile_pictures/{{ \App\Models\User::where('username', $top->author)->first()->profile_url }}"
                                     alt="" width="25" height="25">
                                <strong><i class=""></i>{{ $top->author }}</strong>

                                <small>{{ \Carbon\Carbon::parse($top->created_at )->format('j M, `y')}}</small>

                                <span style="font-weight: bold; margin-left:3px; padding: 3px" class="badge bg-secondary">{{ $top->messages->count() }}</span>
                                <small> replies</small>

                                <span style="font-weight: bold; padding: 3px;" class="badge bg-secondary">{{ $top->views }}</span>
                                <small>views</small>
                            </span>
                                @if($top->tags->count() > 0)
                                    @foreach($top->tags as $t_tag)
                                        <span class="badge bg-secondary">{{ $t_tag->title }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row col-md-5 disappear-item">
                                <div class="col-md-4" >
                                    <span style="font-weight: bold">{{ $top->messages->count() }}</span>
                                    <small> Replies</small>
                                    <br>
                                    <span style="font-weight: bold; padding-left: 3px">{{ $top->views }}</span>
                                    <small>Views</small>
                                </div>
                                <div class="row col-md-8 profile">
                                    <div class="col-md-8 text-end">
                                    <span style="font-weight: bold; padding: 0">
                                        <a data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                           data-bs-placement="left" title="{{ $top->author }}" data-bs-content="
                                            Joined: {{ \App\Models\User::where('username', $top->author)->first()->joined_date  }}
                                            Level: {{ \App\Models\User::where('username', $top->author)->first()->level  }}
                                            Messages: {{ \App\Models\Message::where('author', $top->author)->count() }}
                                            ">
                                        <strong>{{ $top->author }}</strong>
                                    </a>
                                    </span><br>
                                        <span class="text-secondary">
                                        <button style="padding: 0" class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="{{ \Carbon\Carbon::parse($top->created_at)->format('j M, Y@H:m') }}">
                                            <small>{{ \Carbon\Carbon::parse($top->created_at )->format('j M, `y')}}</small>
                                    </button>
                                    </span>
                                    </div>
                                    <div class="col-md-2 text-start">
                                        <img src="/profile_pictures/{{ \App\Models\User::where('username', $top->author)->first()->profile_url }}"
                                             alt="" width="50" height="50">
                                    </div>
                                </div>
                            </div>

                            <hr style="color: lightgrey">
                        </div>
                    @endforeach

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
    </section>
@endsection
