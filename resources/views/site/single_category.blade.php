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
                <h4 class="category-topics-title">{{ $category_topic->title }}</h4>
                {{ $category_topic->author }}
                @foreach($category_topic->tags as $tag)
                    <span class="badge bg-secondary">{{ $tag->title }}</span>
                @endforeach
            </td>
            <td>
                <img style="float: left;" class="img-circle topic-authors" src="/profile_pictures/{{\App\Models\User::where('username', $category_topic->author)->first()->profile_url }}"
                     alt="" width="30" height="30">
                @foreach($category_topic->messages as $ct_message)
                    <img style="float: left;" class="img-circle message-authors" src="/profile_pictures/{{\App\Models\User::where('username', $ct_message->author)->first()->profile_url }}"
                         alt="" width="30" height="30">
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
