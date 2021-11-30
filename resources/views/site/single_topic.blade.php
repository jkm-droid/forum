@extends('base.index')

@section('content')
    <h4>{{ $topic->title }}</h4>
    {{ $topic->category->title }} |
    @foreach($topic->tags as $t_tag)
        <span class="text-white badge bg-danger">{{ $t_tag->title }}</span>
    @endforeach
    <br>
    <img src="/profile_pictures/{{\App\Models\User::where('username', $topic->author)->first()->profile_url }}" alt="" width="55" height="50">
    {{ $topic->author }}

    <p class="topic-body">
        {{ $topic->body }}
    </p>

    <div class="container col-md-3">
        <table class="table table-borderless table-sm single-topic-table text-center">
            <thead>
            <tr>
                <th>created</th>
                <th>{{ $topic->messages->count() }}</th>
                <th>{{ $topic->views }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <img src="/profile_pictures/{{\App\Models\User::where('username', $topic->author)->first()->profile_url }}"
                         alt="" width="20" height="17">
                    {{  \Carbon\Carbon::parse($topic->created_at)->format('M, y') }}
                </td>
                <td>comments</td>
                <td>views</td>
            </tr>
            </tbody>
        </table>
    </div>

    @foreach($messages as $t_message)
        <div class="single-topic-message">
            <img style="float: left" src="/profile_pictures/{{\App\Models\User::where('username', $t_message->author)->first()->profile_url }}"
                 alt="" width="70" height="60">

            <h6 class="">{{ \Carbon\Carbon::parse($t_message->created_at)->format('j M, y') }}</h6>
            <h6 class="message-padding">{{ $t_message->author }}</h6>
            <hr style="color: lightgrey;">
            <p class="message-padding">{{ $t_message->body }}</p>
            <div class="text-end">
                <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="like">
                    <i class="fa fa-heart"></i>
                </button>

                <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="share this post's link">
                    <i class="fa fa-share"></i>
                </button>

                <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="bookmark this post">
                    <i class="fa fa-bookmark"></i>
                </button>

                <button class="btn text-secondary" data-bs-toggle="tooltip" data-bs-placement="left" title="write a comment">
                    <i class="fa fa-reply"></i>Reply
                </button>
            </div>
        </div>
    @endforeach

@endsection
