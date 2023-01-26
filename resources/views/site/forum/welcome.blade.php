@extends('base.index')

@section('content')
    <p id="success-box" class="text-end fixed-top" style="margin-top: 60px; margin-right: 5px;"></p>

    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"></li>
        </ol>
    </nav>

    <section class="main-content">
        <div class="d-flex justify-content-center" >
            <a class="btn top-options text-primary" href="{{ route('site.forum.list') }}">Forum List</a>
            <a class="btn top-options text-danger" href="{{ route('site.top.topics') }}">Top Topics</a>
            <a class="btn top-options text-success" href="{{ route('topic.show.create.form') }}">
                <i class="fa fa-plus"></i> New Topic
            </a>
        </div>

        <div class="row mt-2">
            <div class="col-md-2 topic-creation-categories">
                @include('includes.member')
                @include('includes.forum_list')
            </div>

            <div class="col-md-10">
                @if(count($topics) > 0)
                    <h4>Latest Topics</h4>

                    <hr>

                    @include('site.forum.partials.latest_topics')

                    @include('site.forum.partials.forum_pagination')

                @else
                    @include('includes.alert')

                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        <div>
                            Sorry..no topics were found
                        </div>
                    </div>
                @endif
            </div>

        </div>
        <script>
            function getTopicStatus(topicId){
                const id = $(this).attr("topic-id");
                console.log(id);
                document.getElementById(id)
                $(document).ready(function() {

                    console.log(topicId);
                    $.ajax({
                        url: '/view/status',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'topic_id': topicId,
                        },
                        success: function (response) {
                            console.log(response);
                        },

                        failure: function (response) {
                            console.log("something went wrong");
                        }
                    });
                });
            }
        </script>
    </section>
@endsection
