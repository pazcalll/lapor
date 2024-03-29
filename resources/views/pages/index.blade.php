<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Jumbo - A fully responsive, HTML5 based admin theme">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, jQuery, web design, CSS3, sass">
    <title>Wadul Guse</title>
    <link rel="stylesheet" href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jumbo-bootstrap.css') }}">
    <link href="{{ asset('lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-buttons-dt/css/buttons.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-buttons-bs4/css/buttons.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jumbo-core.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/dropify/dist/css/dropify.min.css') }}" rel="stylesheet">
    <link id="override-css-id" href="{{ asset('css/theme-dark-cyan.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jumbo-forms.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/jquery-rating/css/star-rating.css') }}" media="all" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('lib/jquery-rating/themes/krajee-uni/theme.css') }}" media="all" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <script src="{{ asset('lib/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('lib/dropify/dist/js/dropify.min.js') }}"></script>
    
    <script src="{{ asset('js/setup.js') }}" defer></script>
    
    <script src="{{ asset('lib/jquery-rating/js/star-rating.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/jquery-rating/themes/krajee-uni/theme.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.0/Chart.js"></script>

    <style>
        .dataTables_paginate {
            float: right !important;
        }
        .dataTables_scrollBody thead {
            visibility: hidden;
        }
        .dark-cyan .btn-secondary, .dark-cyan .gx-btn-secondary, .dark-cyan a.btn-secondary, .dark-cyan a.gx-btn-secondary{
            background-color: #a0a0a0;
            border-color: #a0a0a0;
            color: #fff;
        }
        .dark-cyan .btn-secondary:hover, .dark-cyan .btn-secondary:focus, .dark-cyan .btn-secondary:not([disabled]):not(.disabled):active, .dark-cyan .gx-btn-secondary:hover, .dark-cyan .gx-btn-secondary:focus, .dark-cyan .gx-btn-secondary:not([disabled]):not(.disabled):active, .dark-cyan a.btn-secondary:hover, .dark-cyan a.btn-secondary:focus, .dark-cyan a.btn-secondary:not([disabled]):not(.disabled):active, .dark-cyan a.gx-btn-secondary:hover, .dark-cyan a.gx-btn-secondary:focus, .dark-cyan a.gx-btn-secondary:not([disabled]):not(.disabled):active {
            background-color: #686868;
            border-color: #686868;
            color: #f2f2f2; 
        }
    </style>
</head>

<body id="body" data-theme="dark-indigo" class="dark-cyan">   
    
    <div id="app">
        
    </div>
    
    <!-- Menu Backdrop -->
    <div class="menu-backdrop fade"></div>
    
    <script src="{{ asset('lib/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('lib/bigslide/dist/bigSlide.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-bs4/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-buttons-dt/js/buttons.dataTables.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-buttons-bs4/js/buttons.bootstrap4.js') }}"></script>
</body>
</html>