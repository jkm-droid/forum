@extends('base.index')

@section('content')
    <h5> {{ $category->title }}</h5>
    <div class="col-md-12">
    <table class="table">
        <thead>
        <tr>
            <th>Topic</th>
            <th></th>
            <th>Replies</th>
            <th>Views</th>
            <th>Activity</th>
        </tr>
        </thead>
        <tbody>
        @foreach($category->topics as $category_topic)
        <tr>
            <td>
                <h4 class="category-topics-title">
                    <a href="{{ route('site.single.topic', $category_topic->slug) }}">{{ $category_topic->title }}</a>
                </h4>
                <a class="text-secondary" data-bs-container="body" data-bs-trigger="hover focus" data-bs-toggle="popover"
                   data-bs-placement="top" title="{{ $category_topic->author }}" data-bs-content="
                        Joined: {{ \App\Models\User::where('username', $category_topic->author)->first()->joined_date  }}
                        Level: {{ \App\Models\User::where('username', $category_topic->author)->first()->level  }}
                        Messages: {{ \App\Models\Message::where('author', $category_topic->author)->count() }}
                    ">
                    <strong>{{ $category_topic->author }}</strong>
                </a><br>
                @foreach($category_topic->tags as $tag)
                    <span class="badge bg-secondary">{{ $tag->title }}</span>
                @endforeach
            </td>
            <td>
                <img style="float: left;" class="img-circle topic-authors" src="/profile_pictures/{{\App\Models\User::where('username', $category_topic->author)->first()->profile_url }}"
                     alt="" width="35" height="30">
                @foreach($category_topic->messages as $ct_message)
                    <img style="float: left;" class="img-circle message-authors" src="/profile_pictures/{{\App\Models\User::where('username', $ct_message->author)->first()->profile_url }}"
                         alt="" width="35" height="30">
                @endforeach
            </td>
            <td>
                <strong>{{ $category_topic->messages->count() }}</strong>
            </td>
            <td>
                <strong>{{ $category_topic->views }}</strong>
            </td>
            <td></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endsection
