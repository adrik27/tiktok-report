<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>{{ $title }} | Tiktok Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('templates/assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ url('templates/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style">

    <!-- Icons -->
    <link href="{{ url('templates/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <script src="{{ url('templates/assets/js/head.js') }}"></script>

    @yield('css')

</head>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">

    <!-- Begin page -->
    <div id="app-layout">


        <!-- Topbar Start -->
        <div class="topbar-custom">
            <div class="container-fluid">
                @include('admin.templates.partials.header')
            </div>
        </div>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <div class="app-sidebar-menu">
            <div class="h-100" data-simplebar="">

                @include('admin.templates.partials.sidebar')

            </div>
        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- container-fluid -->
            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col fs-13 text-muted text-center">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> - Made with <span class="mdi mdi-heart text-danger"></span> by <a
                                href="https://landinginovra.vercel.app/" class="text-reset fw-semibold">MTech.com</a>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="{{ url('templates/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ url('templates/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('templates/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ url('templates/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ url('templates/assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('templates/assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ url('templates/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="https://cdn.tiny.cloud/1/ik9ishezmwr2futc43kkp753xtypyd7iswc3eomaosi2ztmn/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>

    {{-- <!-- Apexcharts JS -->
    <script src="{{ url('templates/assets/libs/apexcharts/apexcharts.min.js') }}"></script> --}}

    <!-- for basic area chart -->
    <script src="{{ url('templates/samples/assets/stock-prices.js') }}"></script>

    {{-- <!-- Widgets Init Js -->
    <script src="{{ url('templates/assets/js/pages/analytics-dashboard.init.js') }}"></script> --}}

    <!-- App js-->
    <script src="{{ url('templates/assets/js/app.js') }}"></script>



    @yield('js')
</body>

</html>
