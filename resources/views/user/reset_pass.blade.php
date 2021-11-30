@extends('base.auth_user_index')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-danger">
            <div class="card-header text-center">
                <h3 class="put-black"><a href="/" class="h3">Industrialising Africa<br><small><strong>Publication</strong></small></a></h3>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Reset your password</p>
                @if ($message = Session::get('error'))
                    <p class="alert alert-danger">{{ $message }}</p>
                @endif
                <form action="{{ route('user.reset_pass') }}" method="post">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="email" placeholder="Email" />
                        @if ($errors->has('email'))
                            <div class="text-danger form-text">{{ $errors->first('email') }}</div>
                        @endif
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password" />
                        @if ($errors->has('password'))
                            <div class="text-danger form-text">{{ $errors->first('password') }}</div>
                        @endif
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password_confirm" class="form-control" placeholder="Password Confirm" />
                        @if ($errors->has('password_confirm'))
                            <div class="text-danger form-text">{{ $errors->first('password_confirm') }}</div>
                        @endif
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat put-gold background-black">Reset My Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
