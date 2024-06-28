<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        @if (auth()->user()->privilege === 'master')
            <a href="{{ route('logs') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('imgs/icons/djezzy.png') }}" alt="djezzy-icon">
                <span class="d-none d-lg-block">CRM</span>
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('imgs/icons/djezzy.png') }}" alt="djezzy-icon">
                <span class="d-none d-lg-block">CRM</span>
            </a>
        @endif

        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown">

                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span id="notifCount" class="badge bg-danger badge-number"></span>
                </a><!-- End Notification Icon -->

                <ul id="notifications" class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                    style="max-height: 300px;overflow-y: auto;">
                    <li id="nb_notif" class="dropdown-header">
                        You have 0 new notifications
                    </li>
                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->


        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
