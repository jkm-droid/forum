<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- topic creation form button -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('site.show.topic.form') }}" style="font-weight: bold;">
                        <i class="fa fa-plus"></i> New Topic
                    </a>
                </li>
                <!-- end topic creation form button -->

            @if(\Illuminate\Support\Facades\Auth::check())
                <!-- Notifications Dropdown Menu -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications.view.all') }}" role="button"  aria-expanded="false">
                            <i class="fa fa-bell fa-lg"></i>
                            <span class="badge bg-danger" style="position: relative;top: -10px;left: -15px;  border-radius: 50%;  font-size: 10px">
                                <strong>{{ $user->all_notifications }}</strong>
                            </span>
                        </a>
                    </li>
                    <!-- end Notifications Dropdown Menu -->

                    <!--user profile -->
                    <li class="nav-item dropdown no-arrow" style="margin-right: 30px">
                        <a class="nav-link " href="#" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><strong>{{ $user->username }}</strong></span>
                            <img src="/profile_pictures/{{ $user->profile_url }}" alt=""
                                 class="img-profile rounded-circle" height="30" width="30" >
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown" style="margin-right: 30px">
                            <a class="dropdown-item" href="{{ route('profile.view', $user->username) }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('profile.settings', $user->username) }}">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('user.logout') }}" >
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                    <!--end user profile -->
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('show.register') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('show.login') }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
