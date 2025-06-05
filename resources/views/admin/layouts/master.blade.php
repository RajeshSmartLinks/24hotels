<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Masila Hoildays | Booking Engine | Admin">
    <meta name="keywords" content="Masila Hoildays,Booking Engine,Admin">
    <meta name="author" content="Rajesh Vuppala">
    <title>{{env('APP_NAME')}} - {{ !empty($title) ? $title : $titles['title']}}</title>
    <link href="{{asset('frontEnd/images/favicon.png')}}" rel="icon" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/extensions/tether-theme-arrows.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/extensions/tether.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/extensions/shepherd-theme-default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/core/colors/palette-gradient.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/pages/dashboard-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/pages/card-analytics.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/plugins/tour/tour.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/css/plugins/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin-assets/vendors/css/extensions/toastr.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    {{-- <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css"> --}}
    <!-- END: Custom CSS-->
   
    {{-- CKEditor CDN --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable_inline {
            min-height: 300px !important;
        }
        </style>
    @yield('extrastyle')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

   @include('admin/layouts/header')

   @include('admin/layouts/menu')

   @yield('content')
   

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">COPYRIGHT &copy; {{date('Y')}}<a class="text-bold-800 grey darken-2" href="{{url('/')}}" target="_blank">24 flights,</a>All rights Reserved</span>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('admin-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('admin-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/extensions/tether.min.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/extensions/shepherd.min.js')}}"></script>

    <script src="{{asset('admin-assets/vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('admin-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('admin-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('admin-assets/js/core/app.js')}}"></script>
    <script src="{{asset('admin-assets/js/scripts/components.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('admin-assets/vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="{{asset('admin-assets/js/scripts/pages/dashboard-analytics.js')}}"></script>
    <script src="{{asset('admin-assets/js/scripts/datatables/datatable.js')}}"></script>
    <script src="{{asset('admin-assets/js/scripts/tooltip/tooltip.js')}}"></script>
    <!-- END: Page JS-->
    <script>
        ClassicEditor
        .create( document.querySelector( '#ckeditor_en' ))
        .catch( error => {
        console.error( error );
        } );
        ClassicEditor
        .create( document.querySelector( '#ckeditor_ar' ) )
        .catch( error => {
        console.error( error );
        } );
    </script>
    @yield('extrascript')

</body>
<!-- END: Body-->

</html>