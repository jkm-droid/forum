@extends('base.index')

@section('content')
    <div class="main-content" style="padding-top: 20px">
        <div class="row">
            <div class="col-md-3 comment-creation-categories">
                @include('includes.category')
            </div>
            <div class="col-md-9">
                <div class="col-12">
                    <div class="card card-outline card-dark comment-creation-form">
                        <div class="card-header">
                            <h4><strong>{{ $user->username }}</strong> you are editing your comment</h4>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('message.update.reply', $comment->comment_id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="card-body m-1">
                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Associated Topic</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $topic->title }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Topic Category</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{ $topic->category->title }}">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="body" class="form-label">Comment Body</label>
                                    <textarea class="form-control summernote" name="body" id="body" rows="7">{{ $comment->body }}</textarea>
                                    @if ($errors->has('body'))
                                        <div class="text-danger form-text">{{ $errors->first('body') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit_button" name="edit_comment" class="btn bg-warning">
                                    <i class="fa fa-edit"></i> Edit comment
                                </button>
                            </div>

                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
