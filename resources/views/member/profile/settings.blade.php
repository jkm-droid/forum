@extends('base.index')

@section('content')
    <!-- Page Heading -->
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
        <ol class="breadcrumb" >
            <li class="breadcrumb-item"><a href="/">Profile</a></li>
            <li class="breadcrumb-item"><a href="">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Settings</li>
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

            <h3>Account Settings</h3>

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

            <form id="profile-settings" action="{{ route('profile.settings.update',$user->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="user_name" class="form-label put-black put-bold">Username</label>
                        <input type="text" name="username" value="{{$user->username}}" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="email" class="form-label put-black put-bold">Email Address</label>
                    <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="enter email" id="email" readonly>
                </div>

                <div class="mb-3 row">
                    <label for="profile_picture" class="form-label put-black put-bold">Profile Avatar</label><br>
                    <a href="{{ route('profile.show.edit', $user->user_id) }}">
                        <img src="/profile_pictures/{{ $user->profile_url }}" alt="">
                    </a>
                    <div class="col-sm-10 text-success">
                        Click the image to change your avatar
                    </div>
                </div>

                @if($profile == null)
                    <div class="col-md-12">
                        <label for="location" class="form-label put-black put-bold">Current Location</label><br>
                        <select name="country" class="form-select form-control" aria-label="Default select example" autofocus>
                            <option value="" disabled>Select Current Location</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="dob" class="form-label put-black put-bold">Date of Birth</label>
                        <input type="date" class="form-control" name="dob">
                        <div id="emailHelp" class="form-text text-danger">Date of birth will be unchangeable once created</div>
                    </div>

                    <div class="col-md-12">
                        <label for="website" class="form-label put-black put-bold">Website</label>
                        <input type="text" class="form-control" name="website" placeholder="Enter your website">
                    </div>

                    <div class="col-md-12">
                        <label for="gender" class="form-label put-black put-bold">Select Gender</label>
                        <select name="gender" class="form-select form-control" aria-label="Default select example" autofocus>
                            <option value="" disabled>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="about" class="form-label put-black put-bold">Bio</label>
                        <textarea rows="5" type="text" class="form-control" name="about" placeholder="Write a short bio" ></textarea>
                    </div>

                @else
                    <div class="col-md-12">
                        <label for="location" class="form-label put-black put-bold">Current Location</label><br>
                        <select name="country" class="form-select form-control" aria-label="Default select example" autofocus>
                            @if($profile->country != null)
                                <option value="{{ $profile->country }}" selected>{{ $profile->country }}</option>
                            @endif
                            <option value="" disabled>Select Current Location</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="dob" class="form-label put-black put-bold">Date of Birth</label>
                        @if($profile->dob == null)
                            <input type="date" class="form-control" name="dob">
                        @else
                            <input type="text" class="form-control" name="dob" value="{{ $profile->dob }}" readonly>
                        @endif
                        <div id="emailHelp" class="form-text">Date of birth will be unchangeable once created</div>
                    </div>

                    <div class="col-md-12">
                        <label for="website" class="form-label put-black put-bold">Website</label>
                        @if($profile->website == null)
                            <input type="text" class="form-control" name="website" placeholder="Enter your website">
                        @else
                            <input type="text" class="form-control" name="website" placeholder="Enter your website" value="{{ $profile->website }}">
                        @endif
                    </div>

                    <div class="col-md-12">
                        <label for="gender" class="form-label put-black put-bold">Select Gender</label>
                        <select name="gender" class="form-select form-control" aria-label="Default select example" autofocus>
                            @if($profile->gender != null)
                                <option value="{{ $profile->gender }}" selected>{{ $profile->gender }}</option>
                            @endif
                            <option value="" disabled>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="about" class="form-label put-black put-bold">Bio</label>
                        @if($profile->about == null)
                            <textarea rows="5" type="text" class="form-control" name="about" placeholder="Write a short bio" ></textarea>
                        @else
                            <textarea rows="5" type="text" class="form-control" name="about">{{ $profile->about }}</textarea>
                        @endif
                    </div>

                @endif

                <br>

                <button type="submit" id="submit_button" value="Update My Avatar"  class="btn btn-info">
                    <i class="fa fa-save"></i>
                    Update My Profile
                </button>

            </form>
        </div>

    </div>
@endsection
