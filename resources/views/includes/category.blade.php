
@if(\Illuminate\Support\Facades\Auth::check())
    <div class="logged-user-profile">
        <div class="">
            <img style="float: left; position: relative;"  src="/profile_pictures/{{ \Illuminate\Support\Facades\Auth::user()->profile_url }}">
        </div>

        <div class="logged-user-details">
            <h6>{{ \Illuminate\Support\Facades\Auth::user()->username }}</h6>
            <h6>Level : {{ \Illuminate\Support\Facades\Auth::user()->level }}</h6>
            <h6>Score : {{ \Illuminate\Support\Facades\Auth::user()->score }}</h6>
            <h6>Messages : {{ \Illuminate\Support\Facades\Auth::user()->total_messages  }}</h6>
        </div>
    </div>
@endif
<table class="table">
    <thead>
    <tr class="text-secondary">
        <th class="categories">Category</th>
        <th class="topics">Topics</th>
    </tr>
    </thead>
    <tbody>
    @foreach($categories as $category)
        <tr>
            <td>
                <h5>
                    <a class="put-black" href="{{ route('site.single.category', $category->slug) }}">{{ $category->title }}</a>
                </h5>
                <span class="text-secondary">{{ $category->description }}</span>
            </td>
            <td style="text-align: end;" class="text-secondary">
                <h6><strong>{{ $category->topics->where('status', 0)->count() }}</strong><small style="font-size: 16px;"> / month</small></h6>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

