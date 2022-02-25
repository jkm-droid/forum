@extends('base.index')

@section('content')
    <div class="main-content" style="padding-top: 20px">
        <div class="row">
            <div class="col-md-3 topic-creation-categories">
                @include('includes.category')
            </div>
            <div class="col-md-9">
                <div class="col-12">
                    <div class="card card-outline card-dark topic-creation-form">
                        <div class="card-header">
                            <h2>{{ \Illuminate\Support\Facades\Auth::user()->username }} you are creating  a new thread</h2>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('topic.save') }}" id="form_submit" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body m-1">
                                <div class="">
                                    <div class="col-md-12">
                                        <label for="title" class="form-label">Topic Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="enter topic title" value="{{ old('title') }}">
                                        @if ($errors->has('title'))
                                            <div class="text-danger form-text">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>

                                </div>

                                <div class="">
                                    <div class="mt-3">
                                        <label for="category" class="form-label">Topic Category</label>
                                        <select name="category" id="category" class="form-select form-control" aria-label="Default select example" autofocus>
                                            <option value="" disabled selected>Select topic category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old($category->id) == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <div class="text-danger form-text">{{ $errors->first('category') }}</div>
                                        @endif
                                    </div>

                                </div>

                                <div class="mt-4">
                                    <label for="body" class="form-label">Topic Description / Body</label>
                                    <textarea class="form-control summernote" name="body" id="body" rows="7">{{ old('body') }}</textarea>
                                    @if ($errors->has('body'))
                                        <div class="text-danger form-text">{{ $errors->first('body') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="card-footer">
                                <label for="title" class="form-label">Topic Tags <small>(Multiple tags should be separated by commas(,))</small></label>
                                <input type="text" name="tags" class="form-control" placeholder="enter topic tags">
                                <hr>
                                <button type="submit" id="submit_button" value="Post Topic" name="save_topic" class="btn bg-warning">
                                    <i class="fa fa-share"></i> Post Topic</button>
                            </div>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
