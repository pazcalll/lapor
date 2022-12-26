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
                                <a class="dropdown-toggle user-fullname" href="#" role="button" id="userAccount"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pelanggan
                                </a>

                                <span class="dropdown-menu dropdown-menu-left" aria-labelledby="userAccount">
                                    <a class="dropdown-item" href="javascript:void(0)" onclick="profilePage()">
                                        <i class="zmdi zmdi-account zmdi-hc-fw mr-2"></i>
                                        Profil
                                    </a>
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
                    <li class="nav-header"><span class="nav-text">Pelanggan</span></li>
                    <li class="menu">
                        <a href="javascript:void(0)">
                            <i class="zmdi zmdi-view-list zmdi-hc-fw"></i>
                            <span class="nav-text">Laporan</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="javascript:void(0)" onclick="homePage(); $('.menu-backdrop').click()"><span class="nav-text">Buat Laporan</span></a></li>
                            <li><a href="javascript:void(0)" onclick="reportPage(); $('.menu-backdrop').click()"><span class="nav-text">Antrean Laporan</span></a></li>
                            <li><a href="javascript:void(0)" onclick="reportHistoryPage(); $('.menu-backdrop').click()"><span class="nav-text">Riwayat Laporan</span></a></li>
                        </ul>
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
                                'history.js',
                                'profile.js',
                                'report.js',
                            ]
                            let js = [];
                            files.forEach((file, _index) => {
                                js.push(document.createElement('script'))
                                js[_index].setAttribute('type', 'text/javascript');
                                js[_index].setAttribute('src', webBaseUrl+'/js/customer/'+file);
                                js[_index].setAttribute('id', file);
                                document.head.appendChild(js[_index]);
                            });
                            // let indexjs = document.createElement('script');
                            // indexjs.setAttribute('type', 'text/javascript');
                            // indexjs.setAttribute('src', webBaseUrl+'/js/customer.js');
                            // document.head.appendChild(indexjs)
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