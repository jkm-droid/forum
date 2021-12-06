@if(\Illuminate\Support\Facades\Auth::check())
    @include('includes.logged_user_details')
@else
    <div class="text-start">
        <a class="btn top-options" href="{{ route('show.register') }}">
            <i class="fa fa-user"></i> Sign Up Now!
        </a>
    </div>
@endif
<h5>Forum List</h5>
<div class="accordion" id="accordionPanelsStayOpenExample">
    @foreach($forum_list as $forum)
        <div class="accordion-item">
            <h5 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" style="font-size: 22px; padding: 5px;" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne-{{ $forum->id }}" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    {{ $forum->title }}
                </button>
            </h5>
            <div id="panelsStayOpen-collapseOne-{{ $forum->id }}" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    @foreach($forum->categories as $forum_category)
                        <h6>
                            <a href="{{ route('site.single.category', $forum_category->slug) }}">{{ $forum_category->title }}</a>
                        </h6>
                        @if ($loop->index == 5)
                            @break
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
