@extends('base.index')

@section('content')
    <div class="main-content" style="padding-top: 20px">
        <div class="row">
            <div class="col-md-3 message-creation-categories">
                @include('includes.category')
            </div>
            <div class="col-md-9">
                <div class="col-12">
                    <div class="card card-outline card-dark message-creation-form">
                        <div class="card-header">
                            <h4><strong>{{ $user->username }}</strong> you are editing your message</h4>
                        </div>
                        <!-- /.card-header -->

                        <form role="form" method="post" action="{{ route('message.update', $message->message_id) }}" enctype="multipart/form-data">
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
                                    <label for="body" class="form-label">Message Body</label>
                                    <textarea class="form-control summernote" name="body" id="body" rows="7">{{ $message->body }}</textarea>
                                    @if ($errors->has('body'))
                                        <div class="text-danger form-text">{{ $errors->first('body') }}</div>
                                    @endif
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" id="submit_button" name="edit_message" class="btn bg-warning">
                                    <i class="fa fa-edit"></i> Edit Message
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
