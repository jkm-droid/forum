@extends('base.index')

@section('content')
    <div class="row mt-4">
        <div class="col-md-3 disappear-item">
            @include('includes.category')
        </div>

        <div class="col-md-9">
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

            <form id="profile-settings" action="{{ route('profile.settings.update',$user->username) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="user_name" class="form-label">Username</label>
                        <input type="text" name="username" value="{{$user->username}}" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="{{$user->email}}" class="form-control" placeholder="enter email" id="email" readonly>
                </div>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="profile_picture" class="form-label">Profile Avatar</label><br>
                        <a href="{{ route('show.profile.edit', $user->username) }}">
                            <img src="/profile_pictures/{{ $user->profile_url }}" alt="">
                        </a>
                        Click the image to change your avatar
                    </div>

                </div>

                <div class="col-md-12">
                    <label for="location" class="form-label">Location</label><br>
                    <select name="country" class="form-select form-control" aria-label="Default select example" autofocus>
                        @if($user->country)
                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                        @endif
                        <option value="" disabled selected>Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('country'))
                        <div class="text-danger form-text"><small>{{ $errors->first('country') }}</small></div>
                    @endif
                </div>

                <div class="col-md-12">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" value="">
                </div>

                <div class="col-md-12">
                    <label for="website" class="form-label">Website</label>
                    <input type="text" class="form-control" name="website" placeholder="Enter your website" value="">
                </div>

                <div class="col-md-12">
                    <label for="website" class="form-label">Select Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" name="gender_m" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" name="gender_f" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            Female
                        </label>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="about" class="form-label">Bio</label>
                    <textarea rows="5" type="text" class="form-control" name="about" placeholder="Write a short bio" ></textarea>
                </div>

                <br>

                <div class="col-md-3 d-grid">
                    <button type="submit" id="submit_button" value="Update My Avatar"  class="btn btn-info">
                        <i class="fa fa-save"></i>
                        Update My Profile
                    </button>
                </div>

            </form>
        </div>

    </div>
@endsection
