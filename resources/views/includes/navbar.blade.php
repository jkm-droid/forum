<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top position-fixed" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><h1>Zowari</h1></a>
        {{--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"--}}
        {{--                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
        {{--            <span class="navbar-toggler-icon"></span>--}}
        {{--        </button>--}}
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop"
                aria-controls="offcanvasWithBackdrop">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <form class="d-flex justify-content-center">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- topic creation form button -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('topic.show.create.form') }}" style="font-weight: bold;">
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
                                <strong>{{ count($user->unreadNotifications) }}</strong>
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
                            <a class="dropdown-item" href="{{ route('profile.view', $user->user_id) }}">
                                <i class="fa fa-user fa-sm text-secondary"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="{{ route('bookmark.all.bookmarks', $user->user_id) }}">
                                <i class="fa fa-bookmark fa-sm text-secondary"></i>
                                Bookmarks
                            </a>
                            <a class="dropdown-item" href="{{ route('profile.settings', $user->user_id) }}">
                                <i class="fa fa-cogs fa-sm text-secondary"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="{{ route('member.activity.log') }}">
                                <i class="fa fa-list fa-sm text-secondary"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('user.logout') }}" >
                                <i class="fa fa-sign-out fa-sm text-secondary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                    <!--end user profile -->
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.show.register') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.show.login') }}">Login</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBackdropLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

        @if(\Illuminate\Support\Facades\Auth::check())

            <!--user profile -->
                <strong>{{ $user->username }}</strong>
                <!-- topic creation form button -->
                <a href="{{ route('topic.show.create.form') }}" style="font-weight: bold;">
                    <i class="fa fa-plus text-secondary"></i> New Topic
                </a>
                <!-- end topic creation form button -->

                <!-- Dropdown - User Information -->
                <a href="{{ route('profile.view', $user->user_id) }}">
                    <i class="fa fa-user fa-sm text-secondary"></i>
                    Profile
                </a>
                <a  href="{{ route('bookmark.all.bookmarks', $user->user_id) }}">
                    <i class="fa fa-bookmark fa-sm text-secondary"></i>
                    Bookmarks
                </a>
                <a  href="{{ route('profile.settings', $user->user_id) }}">
                    <i class="fa fa-cogs fa-sm text-secondary"></i>
                    Settings
                </a>
                <a  href="{{ route('member.activity.log') }}">
                    <i class="fa fa-list fa-sm text-secondary"></i>
                    Activity Log
                </a>
                <!-- Notifications Dropdown Menu -->
                <a href="{{ route('notifications.view.all') }}" role="button"  aria-expanded="false">
                    <i class="fa fa-bell fa-sm text-secondary"></i>
                    Notifications
                    <span class="badge bg-danger" style="font-size: smaller; padding: 1px">
                        {{ count($user->unreadNotifications) }}
                    </span>
                </a>
                <!-- end Notifications Dropdown Menu -->

                <div class="dropdown-divider"></div>

                <a href="{{ route('user.logout') }}" >
                    <i class="fa fa-sign-out fa-sm text-secondary"></i>
                    Logout
                </a>
                <!--end user profile -->
            @else
                <a class="nav-link" href="{{ route('user.show.register') }}">Register</a>
                <a class="nav-link" href="{{ route('user.show.login') }}">Login</a>
            @endif
            <div class="dropdown-divider"></div>
            @include('includes.forum_list')
        </ul>
    </div>
</div>
