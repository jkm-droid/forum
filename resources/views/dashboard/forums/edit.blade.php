@extends('base.admin')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('show.all.forums') }}">Forums</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit "{{ $forum->title }}"</li>
        </ol>
    </nav>
    <!--End Page Heading -->

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                {{--                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>--}}
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-start">
                            <h1 class="h4 text-gray-900 mb-4"> <strong>Edit</strong> Forum</h1>
                        </div>
                        <form  action="{{ route('forum.edit', $forum->id) }}">

                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="title" class="form-label">Forum Title</label>
                                    <input type="text" name="title" class="form-control form-control-user" id="exampleFirstName"
                                           placeholder="Enter the forum title" value="{{ $forum->title}}">
                                    @if ($errors->has('title'))
                                        <div class="text-danger form-text">{{ $errors->first('title') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="title" class="form-label">Forum Description</label>
                                    <textarea type="text" rows="4" name="description" class="form-control form-control-user"
                                           placeholder="Write a short forum description">{{ $forum->description }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="text-danger form-text">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary btn-user">
                                <i class="fa fa-save"></i> Update Forum
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
