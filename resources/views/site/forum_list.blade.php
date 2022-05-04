@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">Forum</li>
            <li class="breadcrumb-item active" aria-current="page">All</li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-3 topic-creation-categories">
            @include('includes.category')
        </div>
        <div class="col-md-9">
            <h5>Forum List</h5>
            <div class="accordion" id="accordionPanelsStayOpenExample">
                @foreach($forum_list as $forum)
                    <div class="accordion-item">
                        <h4 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" style="padding: 5px; background-color: lightgrey; color: black" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne-{{ $forum->id }}" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                {{ $forum->title }} ({{ $forum->topics->count() }} Topics)
                            </button>
                        </h4>
                        <div id="panelsStayOpen-collapseOne-{{ $forum->id }}" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body" style="padding-left: 20px">
                                <div class="row">
                                    @foreach($forum->categories as $forum_category)
                                        <div class="col-md-6">
                                            @foreach($forum_category->topics as $topic)
                                                @if($loop->first)
                                                    <div style="float: left; margin-right: 10px;">
                                                        <img src="/profile_pictures/{{ $topic->user->profile_url }}" alt="" width="50" height="50">
                                                    </div>

                                                    <a style="font-size: 17px;" href="{{ route('site.single.category', $forum_category->slug) }}">{{ $forum_category->title }}</a><br>
                                                    <small class="disappear-item">{{ $forum_category->description }}</small>

                                                <span class="show-on-mobile">
                                                    <strong><small> {{ $topic->author }}</small></strong>
                                                    <small>{{ \Carbon\Carbon::parse($topic->created_at)->format('j M, `y') }}</small></span>
                                                @endif
                                            @endforeach

                                        </div>
                                        <div class="col-md-3 topics-messages topic-text">

                                            <span class="col-md-5"> <span class="badge bg-secondary" style="padding: 3px 3px 2px;">{{ $forum_category->topics->count() }}</span> Topics</span>
                                            <br class="disappear-item">
                                            <span class="col-md-7"><span class="badge bg-secondary" style="padding: 3px 3px 2px;">
                                                    {{ \App\Models\Category::thousandsCurrencyFormat($forum_category->messages->count()) }}
                                                </span> Messages</span>
                                        </div>

                                        <div class="row col-md-3 disappear-item" style="padding-top: 0">
                                            @foreach($forum_category->topics as $topic)
                                                @if($loop->first)
                                                    <div class="col-md-5 d-flex justify-content-end text-end">
                                                        <img src="/profile_pictures/{{ $topic->user->profile_url }}" alt="" width="50" height="50" class="disappear-item">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <button class="btn text-secondary"  style="padding: 0; font-size: small" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ \Carbon\Carbon::parse($topic->created_at)->format('j M, Y@H:m') }}">
                                                            <small>{{ \Carbon\Carbon::parse($topic->created_at)->format('j M, `y') }}</small>
                                                        </button>
                                                        <br>
                                                        <a  class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                                            data-bs-placement="top" title="{{ $topic->author }}" data-bs-content="
                                                                Joined: {{ $topic->user->joined_date  }}
                                                                Level: {{ $topic->user->level  }}
                                                                Messages: {{ $topic->where('author', $topic->author)->count() }}
                                                            ">
                                                            <strong>
                                                                <small>
                                                                    @if(\Illuminate\Support\Str::contains($topic->author,'.'))
                                                                        {{ strtok($topic->author,'.') }}
                                                                    @else
                                                                        {{ $topic->author }}
                                                                    @endif
                                                                </small>
                                                            </strong>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <hr style="margin-top: 10px">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
