@extends('base.index')

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-md-3">
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
                                <h3>
                                    <a class="put-black" href="{{ route('site.single.category', $category->slug) }}">{{ $category->title }}</a>
                                </h3>
                                <span class="text-secondary">{{ $category->description }}</span>
                            </td>
                            <td style="text-align: end;" class="text-secondary">
                                <h5><strong>{{ $category->topics->where('status', 0)->count() }}</strong><small style="font-size: 16px;"> / month</small></h5>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="col-md-9">
                <h4>Latest Topics</h4><hr>
                @foreach($topics as $topic)
                    <div class="row">
                        <div class="col-md-8">
                            <img style="float: left;" src="/profile_pictures/{{\App\Models\User::where('username', $topic->author)->first()->profile_url }}" alt="" width="55" height="50">
                            <h5 class="latest-topic-content">
                                <a class="put-black" href="{{ route('site.single.topic', $topic->slug) }}">{{ $topic->title }}</a>
                            </h5>
                            <h5 class="latest-topic-content text-secondary">by {{ $topic->author }} <small>at</small> {{  \Carbon\Carbon::parse($topic->created_at)->format('j M, y') }}</h5>
                            @if($topic->tags)
                                <span class="latest-topic-content">
                                @foreach($topic->tags as $topic_tag)
                                        <span class="badge bg-success">{{ $topic_tag->title }}</span>
                                    @endforeach
                                </span>
                            @else
                            @endif
                        </div>
                        <div class="col-md-2">
                            <table>
                                <tbody>
                                <tr class="change-padding">
                                    <td>
                                        <h6>Messages: </h6>
                                    </td>
                                    <td style="padding-left: 30px;">
                                        {{ $topic->messages->count() }}
                                    </td>
                                </tr>
                                <tr class="disappear-item">
                                    <td>
                                        <h6>Views:</h6>
                                    </td>
                                    <td style="padding-left: 30px;">
                                        {{ $topic->views }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2 moments-ago-section">
                            <h5 class="disappear-item">
                                {{ $topic->formatted_topic_time }}
                            </h5>
                            <h5 class="disappear-item">
                                {{ $topic->author }}
                            </h5>
                        </div>
                    </div>

                    <hr style="color: lightgrey;">
                @endforeach
                <div class="d-flex justify-content-center">
                    {!! $topics->links() !!}
                </div>
            </div>

        </div>
@endsection
