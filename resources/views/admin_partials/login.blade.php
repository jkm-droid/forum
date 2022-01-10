@extends('base.index')

@section('content')

    <div class="auth-box col-md-3 container">

            <div class="card-body">
                @if ($message = Session::get('success'))
                    <p class="alert alert-success">{{ $message }}</p>
                @endif
                @if ($message = Session::get('error'))
                    <p class="alert alert-danger">{{ $message }}</p>
                @endif
                <h5 class="login-box-msg text-center">Sign in to start your session</h5>

                <form action="{{ route('admin.login') }}" method="post">
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

                    <!-- /.col -->
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block form-control text-uppercase">Sign In</button>
                    </div>
                    <!-- /.col -->

                </form>

            </div>
            <!-- /.card-body -->

    </div>
@endsection

