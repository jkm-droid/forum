@extends('base.auth_user_index')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-danger">
            <div class="card-header text-center">
                <h3 class="put-black"><a href="/" class="h3">Industrialising Africa<br><small><strong>Publication</strong></small></a></h3>
            </div>
            <div class="card-body">
                @if ($message = Session::get('success'))
                    <p class="alert alert-success">{{ $message }}</p>
                @endif
                @if ($message = Session::get('error'))
                    <p class="alert alert-danger">{{ $message }}</p>
                @endif
                <p class="login-box-msg">Enter email to start password reset</p>

                <form action="{{ route('user.forgot_submit') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="email" placeholder="Enter your email">
                        @if ($errors->has('email'))
                            <div class="text-danger form-text">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block put-gold background-black">Request Password Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

@endsection
