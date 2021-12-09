<header class="cd-main-header js-cd-main-header">
    <div class="cd-logo-wrapper">
        <a href="{{ route('dashboard') }}" class="cd-logo">
            <img src="assets/img/cd-logo.svg" alt="Logo">
        </a>
    </div>

    <div class="cd-search js-cd-search">
        <form>
            <input class="reset" type="search" placeholder="Search...">
        </form>
    </div>

    <button class="reset cd-nav-trigger js-cd-nav-trigger" aria-label="Toggle menu"><span></span></button>

    <ul class="cd-nav__list js-cd-nav__list">
        <li class="cd-nav__item"><a href="#0">Tour</a></li>
        <li class="cd-nav__item"><a href="#0">Support</a></li>
        <li class="cd-nav__item cd-nav__item--has-children cd-nav__item--account js-cd-item--has-children">
            <a href="#0">
                <img src="{{ asset('profile_pictures/white.tyrell.jpg') }}" alt="avatar">
                <span>Account</span>
            </a>

            <ul class="cd-nav__sub-list">
                <li class="cd-nav__sub-item"><a href="#0">My Account</a></li>
                <li class="cd-nav__sub-item"><a href="#0">Edit Account</a></li>
                <li class="cd-nav__sub-item"><a href="#0">Logout</a></li>
            </ul>
        </li>
    </ul>
</header> <!-- .cd-main-header -->
