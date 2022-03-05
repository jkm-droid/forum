@if(\Illuminate\Support\Facades\Auth::check())
    <div class="logged-user-profile">
        <div class="col-md-6">
            <a href="{{ route('profile.show.edit', $user->user_id) }}" class="put-black" data-bs-toggle="tooltip"
               data-bs-placement="top" title="click to change avatar">
                <img  style="width: fit-content;" src="/profile_pictures/{{ $user->profile_url }}" alt="">
            </a>
        </div>
        <div class="col-md-6 logged-user-details">
            <h6>{{ $user->username }}</h6>
            <h6>Level : {{ $user->level }}</h6>
            <h6>Score : {{ $user->score }}</h6>
            <h6>Messages : {{ $user->total_messages  }}</h6>
        </div>

    </div>
@else
    <div class="text-start">
        <a class="btn top-options" href="{{ route('user.show.register') }}">
            <i class="fa fa-user"></i> Sign Up Now!
        </a>
    </div>
@endif
