@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">Categories</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
        </ol>
    </nav>
    <h5> {{ $category->title }}</h5>
    <div class="col-md-12">
        @if(count($category_topics) <= 0)
            <p class="text-center text-danger">No published topics under this category</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Topic</th>
                    <th></th>
                    <th>Messages</th>
                    <th>Views</th>
                    <th>Activity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($category_topics as $category_topic)
                    <tr>
                        <td>
                            <h5 class="category-topics-title">
                                <a href="{{ route('site.single.topic', $category_topic->slug) }}">{{ $category_topic->title }}</a>
                            </h5>
                            <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                               data-bs-placement="top" title="{{ $category_topic->author }}" data-bs-content="
                            Joined: {{ $category_topic->user->joined_date  }}
                                Level: {{ $category_topic->user->level  }}
                                Messages: {{ $category_topic->where('author', $category_topic->author)->count() }}
                                ">
                                <strong>{{ $category_topic->author }}</strong>
                            </a><br>
                        </td>
                        <td>
                            <div>
                                <img style="float: left;" class="img-circle topic-authors" src="/profile_pictures/{{ $category_topic->user->profile_url }}"
                                     alt="" width="30" height="30">
                            </div>

                            @foreach($category_topic->messages as $ct_message)
                                <img style="float: left;" class="img-circle message-authors" src="/profile_pictures/{{ $ct_message->user->profile_url }}"
                                     alt="" width="30" height="30">
                                @if ($loop->index == 10)
                                    @break
                                @endif
                            @endforeach
                        </td>
                        <td>
                            <strong>{{ $category_topic->messages->count() }}</strong>
                        </td>
                        <td>
                            <strong>{{ $category_topic->views }}</strong>
                        </td>
                        <td>
                            @foreach($category_topic->messages as $ct_message)
                                @if($loop->last)
                                    {{ \Carbon\Carbon::parse($ct_message->created_at)->diffInHours(\Carbon\Carbon::now()) }} h
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
