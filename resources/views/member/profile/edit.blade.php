@extends('base.index')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb" >
            <li class="breadcrumb-item"><a href="/">Profile</a></li>
            <li class="breadcrumb-item"><a href="">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Change Avatar</li>
        </ol>
    </nav>

<div class="row mt-4">
   <div class="col-md-3 disappear-item">
       @include('includes.category')
   </div>

    <div class="col-md-2 show-on-mobile" style="margin-right: 0; display: none;">
        @include('includes.profile.picture')
    </div>

    <div class="col-md-9">
         <span style="display: none;" class="show-on-mobile">
                @include('includes.profile.description')
            </span>

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

        <form action="{{ route('profile.update',$user->user_id) }}" method="POST" enctype="multipart/form-data">
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

            <button type="submit" id="submit_button" value=""  class="btn btn-info">
                <i class="fa fa-save"></i>
                Update My Avatar
            </button>
        </form>
    </div>

</div>
@endsection
