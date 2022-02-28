@if(\Illuminate\Support\Facades\Auth::check())
    @include('includes.member')
@else
    <div class="text-start">
        <a class="btn top-options" href="{{ route('user.show.register') }}">
            <i class="fa fa-user"></i> Sign Up Now!
        </a>
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
                <h6>
                    <a class="put-black" href="{{ route('site.single.category', $category->slug) }}">{{ $category->title }}</a>
                </h6>
                <span class="text-secondary"> <small>{{ $category->description }}</small></span>
            </td>
            <td style="text-align: end;" class="text-secondary;">
                <h6><strong>{{ $category->topics->where('status', 0)->count() }}</strong><small style="font-size: 16px;"> / month</small></h6>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

