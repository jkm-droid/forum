<div class="logged-user-profile">
    <div class="col-md-6 profile-section profile-image">
        <img class="image img-fluid" src="/profile_pictures/{{ $user->profile_url }}" alt="">

        <div class="middle">
            <div class="text text-center">
                <a href="{{ route('show.profile.edit', $user->username) }}" class="put-black">Change Avatar</a>
            </div>
        </div>
    </div>
    <div class="col-md-6 logged-user-details">
        <h6>{{ $user->username }}</h6>
        <h6>Level : {{ $user->level }}</h6>
        <h6>Score : {{ $user->score }}</h6>
        <h6>Messages : {{ $user->total_messages  }}</h6>
    </div>

</div>
