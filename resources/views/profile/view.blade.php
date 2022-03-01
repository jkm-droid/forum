@extends('base.index')

@section('content')

    <div class="row col-md-12">
        <div class="col-md-2 profile-section profile-image" style="margin-right: 0">

            <a href="{{ route('profile.show.edit', $user->user_id) }}" class="put-black" data-bs-toggle="tooltip"
               data-bs-placement="top" title="click to change avatar">
                <img class="image img-fluid" src="/profile_pictures/{{ $user->profile_url }}" alt="">
            </a>
            <span class="disappear-item">
                 @include('includes.forum_list')
            </span>

        </div>

        <div class="col-md-10 profile-section text-start">
            <h5>Username: {{ $user->username }}</h5>
            <h6>Email: {{ $user->email }}</h6>
            <h6>Status: {{ $user->level }}</h6>
            <h6>Joined: {{ $user->created_at }}</h6>
            <table class="table table-responsive profile-section">
                <thead>
                <tr>
                    <th>Messages</th>
                    <th>Likes</th>
                    <th>Rating</th>
                    <th>Score</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        {{ \App\Models\Message::where('author',$user->username)->count() }}
                    </td>
                    <td>25</td>
                    <td>{{ $user->rating }}%</td>
                    <td>
                        {{ $user->score }}
                    </td>
                </tr>
                </tbody>
            </table>

            @include('includes.messages')

        </div>

    </div>

@endsection
