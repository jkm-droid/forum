@extends('base.admin')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('show.all.forums') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add New</li>
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
                            <h1 class="h4 text-gray-900 mb-4">Create a <strong>New</strong> Category</h1>
                        </div>
                        <form method="post" action="{{ route('category.create') }}">
                            @csrf

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="title" class="form-label">Category Title</label>
                                    <input type="text" name="title" class="form-control form-control-user" id="exampleFirstName"
                                           placeholder="Enter the category title" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                        <div class="text-danger form-text">{{ $errors->first('title') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="forum" class="form-label">Forum Title</label>
                                    <select name="forum" class="form-select form-control" aria-label="Default select example" autofocus>
                                        <option value="" disabled selected>Select forum</option>
                                        @foreach($forums as $forum)
                                            <option value="{{ $forum->id }}" {{ old($forum->id) == $forum->id ? 'selected' : '' }}>{{ $forum->title }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('forum'))
                                        <div class="text-danger form-text">{{ $errors->first('forum') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="title" class="form-label">Category Description</label>
                                    <textarea type="text" rows="4" name="description" class="form-control form-control-user"
                                              placeholder="Write a short category description">{{ old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="text-danger form-text">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <button type="submit" class="btn btn-primary btn-user">
                                <i class="fa fa-save"></i> Create Category
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
