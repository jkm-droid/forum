@extends('base.index')

@section('content')
<div class="row mt-4">
   <div class="col-md-3 disappear-item">
       @include('includes.category')
   </div>

    <div class="col-md-9">
        <h3>Change Avatar</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update',$user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="user_name" class="form-label">Username</label>
                    <input type="text" name="username" value="{{$user->username}}" class="form-control" readonly>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="enter email" id="email" readonly>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-12">
                    <label for="profile_picture" class="form-label">Profile Avatar</label>
                    <input type="file" name="profile_picture" class="form-control" id="profile_picture">
                </div>
                <input type="hidden" name="client_id" class="form-control" id="client_id">
            </div>

            <br>

            <div class="col-md-6 offset-md-3 d-grid">
                <input type="submit" id="submit_button" value="Update My Avatar"  class="btn btn-info">
            </div>

        </form>
    </div>

</div>
@endsection
