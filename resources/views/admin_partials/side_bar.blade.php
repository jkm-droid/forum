<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" >
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Forum <sup>1</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Main
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Forums</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Action</h6>
                <a class="collapse-item" href="{{ route('show.forum.create') }}">Add New</a>
                <a class="collapse-item" href="{{ route('show.all.forums') }}">View All</a>
                <a class="collapse-item" href="{{ route('show.drafted.forums') }}">Drafted</a>
                <a class="collapse-item" href="{{ route('show.published.forums') }}">Published</a>
            </div>
        </div>
    </li>

    <!-- topics -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategories"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Categories</span>
        </a>
        <div id="collapseCategories" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Action</h6>
                <a class="collapse-item" href="{{ route('show.category.create') }}">Add New</a>
                <a class="collapse-item" href="{{ route('show.all.categories') }}">View All</a>
                <a class="collapse-item" href="{{ route('show.drafted.categories') }}">Drafted</a>
                <a class="collapse-item" href="{{ route('show.published.categories') }}">Published</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTopics"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Topics</span>
        </a>
        <div id="collapseTopics" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Action</h6>
                <a class="collapse-item" href="{{ route('show.topic.create') }}">Add New</a>
                <a class="collapse-item" href="{{ route('show.all.topics') }}">View All</a>
                <a class="collapse-item" href="{{ route('show.drafted.topics') }}">Drafted</a>
                <a class="collapse-item" href="{{ route('show.published.topics') }}">Published</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNotifications"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Notifications</span>
        </a>
        <div id="collapseNotifications" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Actions</h6>
                <a class="collapse-item" href="{{ route('admin.notifications.show') }}">Topic Alerts</a>
                <a class="collapse-item" href="utilities-border.html">Message Alerts</a>
                <a class="collapse-item" href="utilities-animation.html">User Alerts</a>
                <a class="collapse-item" href="utilities-other.html">Other Alerts</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Others
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
           aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Users</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Actions</h6>
                <a class="collapse-item" href="{{ route('show.all.users') }}">View All</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
        <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
        <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">jkmdroid</a>
    </div>

</ul>
