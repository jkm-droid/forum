@if(\Illuminate\Support\Facades\Auth::check())
    <h5 class="latest-topic-content">
        <a id="{{ $topic->id }}" topic-id="{{ $topic->id }}"  href="{{ route('site.single.topic', $topic->slug) }}">{{ $topic->title }}</a>
    </h5>

    @foreach($user->views as $user_view)
        @if($user_view->topic_id == $topic->id)
            <script type="text/javascript">
                document.getElementById({{ $topic->id }}).style.color = 'red';
            </script>
        @endif
    @endforeach

@else
    <h5 class="latest-topic-content">
        <a class="" href="{{ route('site.single.topic', $topic->slug) }}">{{ $topic->title }}</a>
    </h5>
    <script type="text/javascript">
        document.getElementById({{ $topic->id }}).style.color = 'red';
    </script>
@endif
