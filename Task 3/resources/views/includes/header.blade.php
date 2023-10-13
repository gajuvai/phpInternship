@php
    $active_route = request()
        ->route()
        ->getName();
@endphp

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="p-2 pt-3 text-center brand-wrapper">
        <a href="#" class="brand-img-container"><img src="{{ asset('assets/dist/img/img.png') }}"
                alt="AdminLTE Logo" class="img-fluid">
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar esSidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('assets/dist/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                </div>
            </div>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ $active_route == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('post.index') }}"
                        class="nav-link {{ $active_route == 'post.index' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Post</p>
                    </a>
                </li>
                <li class="nav-item {{ $active_route == 'user.index' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $active_route == 'user.index' ? 'active' : '' }}">
                        <i class="nav-icon fa fa-cog"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link {{ $active_route == 'user.index' ? 'active' : '' }}">
                                <i class="far fa-user nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../mailbox/compose.html" class="nav-link">
                                <i class="fa fa-user-tag nav-icon"></i>
                                <p>Role</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../mailbox/read-mail.html" class="nav-link">
                                <i class="fa fa-list-ul nav-icon"></i>
                                <p>Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--                @if (auth()->user()->hasPermission('list_express_service')) --}}
                {{--                <li class="nav-item"> --}}
                {{--                    <a href="{{route('admin.express_service.index')}}" class="nav-link {{ route('admin.express_service.index') == url()->current() ? 'active': ''}}"> --}}
                {{--                        <i class="nav-icon fas fa-biking"></i> --}}
                {{--                        <p>Express Service</p> --}}
                {{--                    </a> --}}
                {{--                </li> --}}
                {{--                @endif --}}
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="btn btn-sm btn-logout nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        Logout
                    </a>

                </li>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
