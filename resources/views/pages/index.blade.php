<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Jumbo - A fully responsive, HTML5 based admin theme">
    <meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, jQuery, web design, CSS3, sass">
    <title>Jumbo Admin</title>
    <!-- Site favicon -->
    {{-- <link rel='shortcut icon' type='image/x-icon' href='images/favicon.ico' /> --}}
    <!-- /site favicon -->

    {{-- <!-- Font Material stylesheet -->
    <link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
    <!-- /font material stylesheet -->

    <!-- Bootstrap stylesheet -->
    <link href="css/jumbo-bootstrap.min.css" rel="stylesheet">
    <!-- /bootstrap stylesheet -->

    <!-- Perfect Scrollbar stylesheet -->
    <link href="node_modules/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <!-- /perfect scrollbar stylesheet -->

    <!-- Jumbo-core stylesheet -->
    <link href="css/jumbo-core.min.css" rel="stylesheet">
    <!-- /jumbo-core stylesheet --> --}}
    @vite([
        'resources/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css',
        'resources/css/jumbo-bootstrap.min.css',
        'resources/css/jumbo-core.min.css',
        'resources/css/jumbo-forms.css',
        'resources/sass/app.scss',
        'resources/js/app.js',
        'resources/js/functions.js',
    ])

</head>

<body id="body" data-theme="dark-indigo">

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
                                    Robert Johnson
                                </a>

                                <span class="dropdown-menu dropdown-menu-right" aria-labelledby="userAccount">
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="zmdi zmdi-account zmdi-hc-fw mr-2"></i>
                                        Profile
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
                                        <i class="zmdi zmdi-settings zmdi-hc-fw mr-2"></i>
                                        Setting
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)">
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
                    <li class="nav-header"><span class="nav-text">Main</span></li>
                    <li class="menu">
                        <a href="javascript:void(0)">
                            <i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i>
                            <span class="nav-text">Starter</span>
                        </a>
                        <ul class="sub-menu">
                            <li><a href="index.html"><span class="nav-text">Default</span></a></li>
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
            <div class="gx-toolbar">
                <div class="sidebar-mobile-menu d-block d-lg-none">
                    <a class="gx-menu-icon menu-toggle" href="#menu">
                        <span class="menu-icon"></span>
                    </a>
                </div>

                <a class="site-logo" href="index.html">
                    <img src="images/logo.png" alt="Jumbo" title="Jumbo">
                </a>

                <div class="search-bar right-side-icon bg-transparent d-none d-sm-block">
                    <div class="form-group">
                        <input class="form-control border-0" placeholder="" value="" type="search">
                        <button class="search-icon"><i class="zmdi zmdi-search zmdi-hc-lg"></i></button>
                    </div>
                </div>

                <ul class="quick-menu header-notifications ml-auto">

                    <li class="nav-searchbox dropdown d-inline-block d-sm-none">
                        <a href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true"
                           class="d-inline-block icon-btn" aria-expanded="false">
                            <i class="zmdi zmdi-search zmdi-hc-fw"></i>
                        </a>
                        <div aria-hidden="true"
                             class="p-0 dropdown-menu dropdown-menu-right search-bar right-side-icon search-dropdown">
                            <div class="form-group">
                                <input class="form-control border-0" placeholder="" value="" type="search">
                                <button class="search-icon"><i class="zmdi zmdi-search zmdi-hc-lg"></i></button>
                            </div>
                        </div>

                    </li>

                    <li class="dropdown">
                        <a href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" class="d-inline-block"
                           aria-expanded="true">
                            <i class="zmdi zmdi-notifications-active icons-alert animated infinite wobble"></i>
                        </a>

                        <div role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                            <div class="gx-card-header d-flex align-items-center">
                                <div class="mr-auto">
                                    <h3 class="card-heading">Notifications</h3>
                                </div>
                            </div>

                            <div class="dropdown-menu-perfectscrollbar d-flex align-items-center justify-content-center">
                                No new messages as of now!
                            </div>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" class="d-inline-block"
                           aria-expanded="true">
                            <i class="zmdi zmdi-comment-alt-text icons-alert zmdi-hc-fw"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" data-placement="bottom-end"
                             data-x-out-of-boundaries="">
                            <div class="gx-card-header d-flex align-items-center">
                                <div class="mr-auto">
                                    <h3 class="card-heading">Messages</h3>
                                </div>
                            </div>

                            <div class="dropdown-menu-perfectscrollbar1 d-flex align-items-center justify-content-center">
                                No notifications as of now!
                            </div>
                        </div>
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
                        <h2 class="title mb-3 mb-sm-0">Starter Template</h2>
                        <nav class="mb-0 breadcrumb">
                            <a href="index.html" class="breadcrumb-item">Jumbo</a>
                            <a href="index.html" class="breadcrumb-item">Starter</a>
                            <span class="active breadcrumb-item">Default</span>
                        </nav>
                    </div>

                    <div class="jumbotron">
                        <div class="display-4 mb-3">Welcome Jumbo Admin</div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid assumenda deleniti fugiat
                            harum id in ipsa, minima pariatur quae quo repudiandae vitae. Accusamus facere quis ullam.
                            Aliquam labore obcaecati provident. lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid assumenda deleniti fugiat
                            harum id in ipsa, minima pariatur quae quo repudiandae vitae. Accusamus facere quis ullam.
                            Aliquam labore obcaecati provident. lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid assumenda deleniti fugiat
                            harum id in ipsa, minima pariatur quae quo repudiandae vitae. Accusamus facere quis ullam.
                            Aliquam labore obcaecati provident.
                        </p>
                    </div>
                    <p>This is some text.</p>
                    <p>This is another text.</p>
                </div>
            </div>
            <!--/gx-wrapper-->

            <!-- Footer -->
            <footer class="gx-footer">
                <div class="d-flex flex-row justify-content-between">
                    <p> Copyright Company Name © 2018</p>
                    <a href="javascript:void(0)" class="btn-link">BUY NOW</a>
                </div>
            </footer>
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /main container -->

</div>
<!-- /page container -->

<!-- Menu Backdrop -->
<div class="menu-backdrop fade"></div>
<!-- /menu backdrop -->

{{-- <!--Load JQuery-->
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<!--Bootstrap JQuery-->
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--Perfect Scrollbar JQuery-->
<script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<!--Big Slide JQuery-->
<script src="node_modules/bigslide/dist/bigSlide.min.js"></script>

<!--Custom JQuery-->
<script src="js/functions.js"></script> --}}

</body>
</html>