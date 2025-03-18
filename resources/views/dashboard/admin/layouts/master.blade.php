<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ISMS</title>
    @php
        $admin_logos = '';
        $logo_image = '';
        if (
            count(
                DB::table('logo_titles')
                    ->where('status', '1')
                    ->get(),
            ) != 0
        ) {
            $admin_logos = DB::table('logo_titles')->first();
            $favicon = $admin_logos->favicon;
        }
    @endphp

    @if (isset($favicon))
        <link rel="icon" href="{!! URL::to('storage/favicon', $favicon) !!}" />
    @else
        <link rel="icon" href="{{ asset('no_image.png') }}" />
    @endif
    <!-- Google Font: Source Sans Pro -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('admin/plugins/jquery-ui/jquery-ui.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin') }}/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/daterangepicker/daterangepicker.css">

    {{-- Datatable --}}
    <link rel="stylesheet" href="{{ asset('admin/datatable/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('admin/custom/common.css') }}">

    @stack('admin_css')
    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('admin') }}/plugins/jquery/jquery.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <div id="loading"> <div id="loading_content"> </div> </div>

        @include('dashboard.common.common_modal')
        <!-- Navbar -->
        @include('dashboard.admin.layouts.topbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('dashboard.admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->


        @yield('admin_body')


        <!-- /.content-wrapper -->
        @include('dashboard.admin.layouts.footer')
    </div>
    <!-- ./wrapper -->


    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript" src="{{ asset('admin') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script type="text/javascript" src="{{ asset('admin') }}/plugins/chart.js/Chart.min.js"></script>

    <script type="text/javascript" src="{{ asset('admin') }}/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- overlayScrollbars -->
    <script type="text/javascript" src="{{ asset('admin') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script type="text/javascript" src="{{ asset('admin') }}/js/adminlte.js"></script>
    <script type="text/javascript" src="{{ asset('admin/sweetalert.js') }}"></script>


    {{-- Datatable --}}
    <script type="text/javascript" src="{{ asset('admin/datatable/datatable.js') }}"></script>

    {{-- Select2 --}}
    <script type="text/javascript" src="{{ asset('admin') }}/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript" src="{{ asset('admin/custom/common.js') }}"></script>

    <script type="text/javascript" src="{{ asset('admin/js/handlebars.min.js') }}"></script>


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })



        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
            });

            if ("{{ session()->get('success') }}") {
                Toast.fire({
                    icon: 'success',
                    title: "{{ session()->get('success') }}",
                    background: '#e6fdfa',
                    color: '#181317',
                    iconColor: '#07474a',

                })
            } else if ("{{ session()->get('error') }}") {
                Toast.fire({
                    icon: 'error',
                    title: "{{ session()->get('error') }}",
                    background: '#de2929',
                    color: '#ffffff',
                    iconColor: '#ffffff',
                })
            }
        });
    </script>


    <script>
        let employee_auto = {
            routes: {
                zone: "{{ route('admin.employee_auto_search') }}?employee="
            }
        };
        let customer_auto = {
            routes: {
                zone: "{{ route('admin.employee_auto_search') }}"
            }
        };
        let store_wise_invoice_auto = {
            routes: {
                zone: "{{ route('admin.store_wise_invoice_search') }}"
            }
        };
        let store_wise_employee_auto_search = {
            routes: {
                zone: "{{ route('admin.store_wise_employee_auto') }}"
            }
        };

        let invoice_search_auto = {
            routes: {
                zone: "{{ route('admin.invoice_search_auto') }}"
            }
        };
    </script>

    <script>
        // $(document).ajaxStart(function() {
        //     $('#loading').addClass('loading')
        //     $('#loading_content').addClass('loading_content')
        // })

        // $(document).ajaxStop(function() {
        //     $('#loading').removeClass('loading')
        //     $('#loading_content').removeClass('loading_content')
        // })




        //Success Message
        const success_message = (message = '') => {

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter',
                        Swal.stopTimer)
                    toast.addEventListener('mouseleave',
                        Swal.resumeTimer)
                },
            });

            Toast.fire({
                icon: 'success',
                title: message,
                background: '#e6fdfa',
                color: '#181317',
                iconColor: '#07474a',

            })
        }

        const error_message = (message = '') => {

            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter',
                        Swal.stopTimer)
                    toast.addEventListener('mouseleave',
                        Swal.resumeTimer)
                },
            });

            Toast.fire({
                icon: 'error',
                title: message,
                background: '#de2929',
                color: '#ffffff',
                iconColor: '#ffffff',
            })


        }



        // $(document).on("contextmenu", function(e) {
        //     e.preventDefault();
        // });

        // $(document).keydown(function(event) {
        //     if (event.keyCode == 123) { // Prevent F12
        //         return false;
        //     } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
        //         return false;
        //     }
        // });


    </script>

    @stack('admin_js')

</body>

</html>
