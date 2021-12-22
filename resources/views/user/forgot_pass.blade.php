@extends('base.index')

@section('content')
    <div class="auth-box col-md-3 container">
        <div class="card card-outline card-danger">
            <div class="card-header text-center">
                <h3 class="put-black"><a href="/" class="h3">Forum</a></h3>
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
                        <button type="submit" class="btn btn-primary btn-block form-control">Request Password Reset</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

@endsection
