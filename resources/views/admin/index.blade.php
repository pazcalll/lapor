<!-- Loader Backdrop -->
<div class="loader-backdrop">
    <!-- Loader -->
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
        </svg>
    </div>
    <!-- /loader-->
</div>
<!-- loader backdrop -->

<!-- Page container -->
<div class="gx-container">

    <!-- Page Sidebar -->
    <div id="menu" class="side-nav gx-sidebar">
        <div class="navbar-expand-lg">
            <!-- Sidebar header  -->
            <div class="sidebar-header">
                <div class="user-profile">
                    <img class="user-avatar" alt="Domnic" src="images/placeholder.jpg">

                    <div class="user-detail">
                        <h4 class="user-name">
                            <span class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="userAccount"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Admin
                                </a>

                                <span class="dropdown-menu dropdown-menu-right" aria-labelledby="userAccount">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="logout()">
                                        <i class="zmdi zmdi-sign-in zmdi-hc-fw mr-2"></i>
                                        Logout
                                    </a>
                                </span>
                            </span>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- /sidebar header -->

            <!-- Main navigation -->
            <div id="main-menu" class="main-menu navbar-collapse collapse">
                <ul class="nav-menu">
                    <li class="nav-header"><span class="nav-text">Admin</span></li>
                    <li class="menu no-arrow">
                        <a href="javascript:void(0)" onclick="homePage(); $('.menu-backdrop').click()">
                            <i class="zmdi zmdi-widgets zmdi-hc-fw"></i>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="menu">
                        <a href="javascript:void(0)">
                            <i class="zmdi zmdi-view-list zmdi-hc-fw"></i>
                            <span class="nav-text">Laporan</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="javascript:void(0)" onclick="incomingPage(); $('.menu-backdrop').click()"><span class="nav-text">Laporan Masuk</span></a></li>
                            <li><a href="javascript:void(0)" onclick="processPage(); $('.menu-backdrop').click()"><span class="nav-text">Laporan Sedang Diproses</span></a></li>
                            <li><a href="javascript:void(0)" onclick="finishedPage(); $('.menu-backdrop').click()"><span class="nav-text">Laporan Selesai</span></a></li>
                        </ul>
                    </li>
                    <li class="menu no-arrow">
                        <a href="javascript:void(0)" onclick="configPage(); $('.menu-backdrop').click()">
                            <i class="zmdi zmdi-group zmdi-hc-fw"></i>
                            <span class="nav-text">User Config</span>
                        </a>
                    </li>
                    <li class="menu no-arrow">
                        <a href="javascript:void(0)" onclick="facilitiesPage(); $('.menu-backdrop').click()">
                            <i class="zmdi zmdi-window-maximize zmdi-hc-fw"></i>
                            <span class="nav-text">Fasilitas</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /main navigation -->
        </div>
    </div>
    <!-- /page sidebar -->

    <!-- Main Container -->
    <div class="gx-main-container">

        <!-- Main Header -->
        <header class="main-header">
            <div class="gx-toolbar" style="left: 0px">
                {{-- <div class="sidebar-mobile-menu d-block d-lg-none">
                    <a class="gx-menu-icon menu-toggle" href="#menu">
                        <span class="menu-icon"></span>
                    </a>
                </div> --}}

                <a class="site-logo" href="index.html">
                    <span style="color: white; font-size: x-large; font-weight: 700; font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif">
                        Wadul Guse
                    </span>
                </a>

                <ul class="quick-menu header-notifications ml-auto">                    
                    <li class="dropdown">
                        <a class="gx-menu-icon menu-toggle" href="#menu">
                            <span class="menu-icon"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </header>
        <!-- /main header -->

        <!-- Main Content -->
        <div class="gx-main-content">
            <!--gx-wrapper-->
            <div class="gx-wrapper">
                <div class="dashboard">
                    <div class="page-heading d-sm-flex justify-content-sm-between align-items-sm-center">
                        <h2 class="title mb-3 mb-sm-0" id="title-label" style="font-weight: 500; font-size: 28pt"></h2>
                    </div>

                    <div id="content">
                        <script>
                            let files = [
                                'home.js',
                                'facility.js',
                                'finished.js',
                                'process.js',
                                'userConfig.js',
                                'incoming.js',
                            ]
                            let js = [];
                            files.forEach((file, _index) => {
                                js.push(document.createElement('script'))
                                js[_index].setAttribute('type', 'text/javascript');
                                js[_index].setAttribute('src', webBaseUrl+'/js/admin/'+file);
                                js[_index].setAttribute('id', file);
                                document.head.appendChild(js[_index]);
                            });
                        </script>
                    </div>
                </div>
            </div>
            <!--/gx-wrapper-->

        </div>
        <!-- /main content -->

    </div>
    <!-- /main container -->

</div>
<!-- /page container -->