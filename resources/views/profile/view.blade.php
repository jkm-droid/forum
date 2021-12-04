@extends('base.index')

@section('content')

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible col-md-3 offset-md-9">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Success</h5>
            {{ $message }}
        </div>
    @endif
{{--    <div class="row">--}}
{{--        <div class="col-md-3 disappear-item">--}}
{{--            @include('includes.category')--}}
{{--        </div>--}}

        <div class="row col-md-9 main-profile-section">
            <div class="col-md-2 profile-section">
                <img height="300" width="250" src="/profile_pictures/{{ \Illuminate\Support\Facades\Auth::user()->profile_url }}"
                     class="img-circle img-fluid" alt="" style="" /><br>
            </div>

            <div class="col-md-10 profile-section">
                <h5>Username: {{ $user->username }}</h5>
                <h6>Email: {{ $user->email }}</h6>
                <h6>Status: {{ \Illuminate\Support\Facades\Auth::user()->level }}</h6>
                <h6>Joined: {{ \Illuminate\Support\Facades\Auth::user()->created_at }}</h6>
                <table class="table table-responsive profile-section">
                    <thead>
                    <tr>
                        <th>Messages</th>
                        <th>Likes</th>
                        <th>Rating</th>
                        <th>Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            {{ \App\Models\Message::where('author',\Illuminate\Support\Facades\Auth::user()->username)->count() }}
                        </td>
                        <td>25</td>
                        <td>1</td>
                        <td>
                            {{ \Illuminate\Support\Facades\Auth::user()->score }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>

       
{{--    </div>--}}
@endsection
