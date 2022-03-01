
@include('includes.member')

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
            <td style="text-align: end; font-size: smaller;" class="text-secondary;">
                <strong>{{ $category->topics->where('status', 1)->count() }}</strong><small style="font-size: 16px;"> / month</small>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

