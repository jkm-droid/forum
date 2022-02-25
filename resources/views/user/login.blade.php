@extends('base.index')

@section('content')

    <div class="auth-box col-md-6 container">

        <div class="text-center">
            <h3 class="put-black"><a href="/" class="h3">Forum</a></h3>
        </div>
        @if ($message = Session::get('success'))
            <p class="alert alert-success">{{ $message }}</p>
        @endif
        @if ($message = Session::get('error'))
            <p class="alert alert-danger">{{ $message }}</p>
        @endif
        <h5 class="login-box-msg text-center">Sign in to start your session</h5>

        <form action="{{ route('user.login') }}" method="post">
            @csrf
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Email or Username">
                @if ($errors->has('username'))
                    <div class="text-danger form-text"><small>{{ $errors->first('username') }}</small></div>
                @endif
            </div>
            <div class=" mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                @if ($errors->has('password'))
                    <div class="text-danger form-text"><small>{{ $errors->first('password') }}</small></div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary form-control text-uppercase">Sign In</button>

        </form>
        <div class="text-center mt-3">
            <a href="{{ route('user.show.register') }}" class="text-center">I don't have a membership</a><br><br>
            <a href="{{ route('user.show.forgot_pass_form') }}" class="text-center">Forgot password?</a>
        </div>

    </div>
@endsection

