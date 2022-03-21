@extends('base.index')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb" >
            <li class="breadcrumb-item"><a href="/">Portal</a></li>
            <li class="breadcrumb-item"><a href="">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Bookmarks</li>
        </ol>
    </nav>
    <div class="row col-md-12">
        <div class="col-md-2" style="margin-right: 0;">

           @include('includes.profile.picture')

        </div>

        <div class="col-md-10 profile-section text-start">

            @include('includes.profile.description')

            @include('includes.bookmarks')

        </div>

    </div>

@endsection
