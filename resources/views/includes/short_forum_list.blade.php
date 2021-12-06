@if(\Illuminate\Support\Facades\Auth::check())
    <div class="row logged-user-profile">
        <div class="col-md-6 profile-section profile-image">
            <img class="image" src="/profile_pictures/{{ \Illuminate\Support\Facades\Auth::user()->profile_url }}" alt="">

            <div class="middle">
                <div class="text">
                    <a href="{{ route('show.profile.edit', \Illuminate\Support\Facades\Auth::user()->username) }}" class="put-black">Change Avatar</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="logged-user-details">
                <h6>{{ \Illuminate\Support\Facades\Auth::user()->username }}</h6>
                <h6>Level : {{ \Illuminate\Support\Facades\Auth::user()->level }}</h6>
                <h6>Score : {{ \Illuminate\Support\Facades\Auth::user()->score }}</h6>
                <h6>Messages : {{ \Illuminate\Support\Facades\Auth::user()->total_messages  }}</h6>
            </div>
        </div>
    </div>
@endif
<div class="text-center">
    <a class="btn top-options" href="{{ route('show.register') }}">
        <i class="fa fa-user"></i> Sign Up Now!
    </a>
</div>

<h5>Forum List</h5>
<div class="accordion" id="accordionPanelsStayOpenExample">
    @foreach($forum_list as $forum)
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" style="font-size: 25px; padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne-{{ $forum->id }}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    {{ $forum->title }}
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne-{{ $forum->id }}" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    @foreach($forum->categories as $forum_category)
                        <h5><a href="{{ route('site.single.category', $forum_category->slug) }}">{{ $forum_category->title }}</a></h5>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
