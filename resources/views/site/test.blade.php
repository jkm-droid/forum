@extends('base.index')

@section('content')
<nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('site.top.topics') }}">Topics</a></li>
{{--        <li class="breadcrumb-item active" aria-current="page">{{ \Illuminate\Support\Str::limit($topic->title, 20, "...") }}</li>--}}
    </ol>
</nav>
@endsection
