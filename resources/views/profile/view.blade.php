@extends('base.index')

@section('content')
{{--    <div class="row">--}}
{{--        <div class="col-md-3 disappear-item">--}}
{{--            @include('includes.category')--}}
{{--        </div>--}}

        <div class="row col-md-12">
            <div class="col-md-2 profile-section profile-image" style="margin-right: 0">
                <img  src="/profile_pictures/{{ $user->profile_url }}" class="image" alt=""/><br>

                <div class="middle-profile">
                    <div class="text">
                        <a href="{{ route('show.profile.edit', $user->username) }}" class="put-black">Change Avatar</a>
                    </div>
                </div>
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
                        <td>1</td>
                        <td>
                            {{ $user->score }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>


{{--    </div>--}}
@endsection
