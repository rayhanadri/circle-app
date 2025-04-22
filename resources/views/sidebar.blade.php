<!-- Sidebar Start -->
<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                <img src="resources/images/logos/erudesu_logo.png" width="180" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" id="sidebarDashboard" href="{{ route('dashboard') }}" aria-expanded="false">
                        <span>
                            <i class="ti ti-layout-dashboard"></i>
                        </span>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Projects</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" id="sidebarProjects" href="{{ route(name: 'projects') }}"
                        aria-expanded="false">
                        <span>
                            <i class="ti ti-briefcase"></i>
                        </span>
                        <span class="hide-menu">Projects</span>
                    </a>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Submissions</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" id="sidebarArtworks" href="{{ route(name: 'artworks') }}"
                        aria-expanded="false">
                        <span>
                            <i class="ti ti-upload"></i>
                        </span>
                        <span class="hide-menu">Artworks</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" id="sidebarDesigns" href="{{ route(name: 'designs') }}"
                        aria-expanded="false">
                        <span>
                            <i class="ti ti-upload"></i>
                        </span>
                        <span class="hide-menu">Design</span>
                    </a>
                </li>
                {{-- <li class="sidebar-item">
                    <a class="sidebar-link" id="sidebarGoods"  aria-expanded="false">
                        <span>
                            <i class="ti ti-stack"></i>
                        </span>
                        <span class="hide-menu">Design</span>
                    </a>
                </li> --}}
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->
