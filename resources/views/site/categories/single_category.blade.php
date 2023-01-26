@extends('base.index')

@section('content')
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item">Categories</li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
        </ol>
    </nav>
    <h5> {{ $category->title }}</h5>
    <div class="col-md-12">
        @if(count($category_topics) <= 0)
            <p class="text-center text-danger">No published topics under this category</p>
        @else

            @foreach($category_topics as $topic)
                <div class="row col-md-12">

                    @include('site.categories.partials.category_topics')

                    @include('includes.common.message_view_count')

                    @include('includes.common.message_author_profile')

                </div>
                <hr style="color: #cec1c1;">

            @endforeach

            @include('site.categories.partials.categories_pagination')

        @endif
    </div>
@endsection
