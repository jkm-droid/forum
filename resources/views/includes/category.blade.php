@if(\Illuminate\Support\Facades\Auth::check())
    @include('includes.logged_user_details')
@else
    <div class="text-start">
        <a class="btn top-options" href="{{ route('show.register') }}">
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

