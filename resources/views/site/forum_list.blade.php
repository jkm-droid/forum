@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
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
                        <h3 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" style="padding: 5px; font-size: 20px;" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne-{{ $forum->id }}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                {{ $forum->title }} ({{ $forum->topics->count() }} Topics)
                            </button>
                        </h3>
                        <div id="panelsStayOpen-collapseOne-{{ $forum->id }}" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <div class="row">
                                    @foreach($forum->categories as $forum_category)
                                        <div class="col-md-7">

                                            <a style="font-size: 17px;" href="{{ route('site.single.category', $forum_category->slug) }}">{{ $forum_category->title }}</a><br>
                                            <small>{{ $forum_category->description }}</small>
                                        </div>
                                        <div class="row col-md-2" style="font-size: 12px;">

                                            <div class="col-md-5"> {{ $forum_category->topics->count() }} Topics</div>
                                            <div class="col-md-7">{{ \App\Models\Category::thousandsCurrencyFormat($forum_category->messages->count()) }} Messages</div>

                                        </div>

                                        <div class="row col-md-3" style="padding-top: 0">
                                            @foreach($forum_category->topics as $topic)
                                                @if($loop->first)
                                                    <div class="col-md-5 d-flex justify-content-end text-end">
                                                        <img src="/profile_pictures/{{ $topic->user->profile_url }}" alt="" width="50" height="50" class="disappear-item">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <button class="btn text-secondary"  style="padding: 0; font-size: small" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ \Carbon\Carbon::parse($topic->created_at)->format('j M, Y@H:m') }}">
                                                            <small>{{ \Carbon\Carbon::parse($topic->created_at)->format('j M, `y') }}</small>
                                                        </button>

                                                        <a  class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                                                            data-bs-placement="top" title="{{ $topic->author }}" data-bs-content="
                                                                Joined: {{ $topic->user->joined_date  }}
                                                                Level: {{ $topic->user->level  }}
                                                                Messages: {{ $topic->where('author', $topic->author)->count() }}
                                                            ">
                                                            <strong><small> {{ $topic->author }}</small></strong>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>

                                        <hr>
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
