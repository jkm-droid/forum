<div class="logged-user-profile">
    <div class="col-md-6 profile-section profile-image">
        <a href="{{ route('profile.show.edit', $user->user_id) }}" class="put-black" data-bs-toggle="tooltip" data-bs-placement="top" title="click to change avatar">
            <img class="image img-fluid" src="/profile_pictures/{{ $user->profile_url }}" alt="">
        </a>
    </div>
    <div class="col-md-6 logged-user-details">
        <h6>{{ $user->username }}</h6>
        <h6>Level : {{ $user->level }}</h6>
        <h6>Score : {{ $user->score }}</h6>
        <h6>Messages : {{ $user->total_messages  }}</h6>
    </div>

</div>
