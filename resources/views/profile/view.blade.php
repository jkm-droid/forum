@extends('base.index')

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible col-md-3 offset-md-9">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Success</h5>
            {{ $message }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-3 disappear-item">
            @include('includes.category')
        </div>
        <div class="row col-md-9">
            <div class="col-md-2 profile-section">
                <img height="300" width="250" src="/profile_pictures/{{ \Illuminate\Support\Facades\Auth::user()->profile_url }}"
                     class="img-circle img-fluid" alt="" style="" /><br>
            </div>

            <div class="col-md-10 profile-section" style="margin-top: 0">
                <h5>Username: {{ $user->username }}</h5>
                <h6>Email: {{ $user->email }}</h6>
                <h6>Status: {{ \Illuminate\Support\Facades\Auth::user()->level }}</h6>
                <h6>Joined: {{ \Illuminate\Support\Facades\Auth::user()->created_at }}</h6>
                <div class="row col-md-12">
                    <div class="col-md-4">
                        <dl>
                            <dt>Messages</dt>
                            <dd>
                                <a href="/search/member?user_id=1542077" class="fauxBlockLink-linkRow u-concealed">
                                    0
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="pairs pairs--rows pairs--rows--centered">
                            <dt>
                                Rating:
                            </dt>
                            <dd>
                                <a href="/trade/1542077" class="fauxBlockLink-linkRow u-concealed">0%</a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-4">
                        <dl class="pairs pairs--rows pairs--rows--centered">
                            <dt>Score</dt>
                            <dd>
                                0
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
