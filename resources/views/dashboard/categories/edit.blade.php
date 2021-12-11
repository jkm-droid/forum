@extends('base.admin')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('show.all.categories') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit "{{ $category->title }}"</li>
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
                            <h1 class="h4 text-gray-900 mb-4"> <strong>Edit</strong> Category</h1>
                        </div>
                        <form action="{{ route('category.edit', $category->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label for="title" class="form-label">Category Title</label>
                                    <input type="text" name="title" class="form-control form-control-user" id="exampleFirstName"
                                           placeholder="Enter the category title" value="{{ $category->title }}">
                                    @if ($errors->has('title'))
                                        <div class="text-danger form-text">{{ $errors->first('title') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <label class="form-label">Forum Title</label>
                                    <select name="forum" class="form-select form-control" aria-label="Default select example" autofocus>
                                        @if($category->forumlist)
                                                <option value="{{ $category->forumlist->id }}" selected>{{ $category->forumlist->title }}</option>
                                        @endif
                                        <option value="" disabled>Select article category</option>
                                        @foreach($forums as $forum)
                                            <option value="{{ $forum->id }}">{{ $forum->title }}</option>
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
                                              placeholder="Write a short category description">{{ $category->description  }}</textarea>
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
