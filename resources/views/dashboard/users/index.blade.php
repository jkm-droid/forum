@extends('base.admin')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '>'; background-color: white;" aria-label="breadcrumb">
        <ol class="breadcrumb bg-light" >
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Users</li>
        </ol>
    </nav>
    <!--End Page Heading -->

    <div class="card">
        <div class="card-header">
            <a class="btn btn-info btn-sm" href="">{{ $userCount}} Users</a>
        </div>

        <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Score</th>
                <th>Level</th>
                <th>Messages</th>
                <th>Likes</th>
                <th>Topics</th>
                <th>Joined</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $f++ }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->score }}</td>
                    <td>{{ $user->level }}</td>
                    <td>{{ $user->messages->count() }}</td>
                    <td>{{ $user->messages->sum('likes') }}</td>
                    <td>{{ $user->topics->count() }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('j M, Y H:m') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>

        {{ $users->links() }}
    </div>
@endsection
