<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ url('assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/jquery-tags-input/jquery.tagsinput.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/dropzone/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/dropify/dist/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/demo_1/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/jquery-steps/jquery.steps.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="style.css">


    {{--jquery validator css--}}
    <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css">

    <link rel="shortcut icon" href="{{ url('assets/images/favicon.png') }}"/>

    <script src="{{ url('assets/vendors/core/core.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>
    <div class="main-wrapper">
        @extends('layouts.dashboard.sidebar')
        <div class="page-wrapper">
            <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                    <i data-feather="menu"></i>
                </a>
                <div class="navbar-content">
                    <ul class="navbar-nav">
                        {{--<li class="nav-item dropdown nav-notifications">
                            <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i data-feather="bell"></i>
                                <div class="indicator">
                                    <div class="circle"></div>
                                </div>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="notificationDropdown">
                                <div class="dropdown-header d-flex align-items-center justify-content-between">
                                    <p class="mb-0 font-weight-medium">6 New Notifications</p>
                                    <a href="javascript:;" class="text-muted">Clear all</a>
                                </div>
                                <div class="dropdown-body">
                                    <a href="javascript:;" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="user-plus"></i>
                                        </div>
                                        <div class="content">
                                            <p>New customer registered</p>
                                            <p class="sub-text text-muted">2 sec ago</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="gift"></i>
                                        </div>
                                        <div class="content">
                                            <p>New Order Recieved</p>
                                            <p class="sub-text text-muted">30 min ago</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="alert-circle"></i>
                                        </div>
                                        <div class="content">
                                            <p>Server Limit Reached!</p>
                                            <p class="sub-text text-muted">1 hrs ago</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="layers"></i>
                                        </div>
                                        <div class="content">
                                            <p>Apps are ready for update</p>
                                            <p class="sub-text text-muted">5 hrs ago</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="dropdown-item">
                                        <div class="icon">
                                            <i data-feather="download"></i>
                                        </div>
                                        <div class="content">
                                            <p>Download completed</p>
                                            <p class="sub-text text-muted">6 hrs ago</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="dropdown-footer d-flex align-items-center justify-content-center">
                                    <a href="javascript:;">View all</a>
                                </div>
                            </div>
                        </li>--}}
                        <li class="nav-item dropdown nav-profile">
                            <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{url('assets/images/face.png')}}" alt="profile">
                            </a>
                            <div class="dropdown-menu" aria-labelledby="profileDropdown">
                                <div class="dropdown-header d-flex flex-column align-items-center">
                                    <div class="figure mb-3">
                                        <img src="{{url('assets/images/face.png')}}" alt="profile">
                                    </div>
                                    <div class="info text-center">
                                        <p class="name font-weight-bold mb-0">{{\Illuminate\Support\Facades\Auth::user()->name}}</p>
                                        <p class="email text-muted mb-3">{{\Illuminate\Support\Facades\Auth::user()->email}}</p>
                                    </div>
                                </div>
                                <div class="dropdown-body">
                                    <ul class="profile-nav p-0 pt-3">
                                        {{--<li class="nav-item">
                                            <a href="#" class="nav-link">
                                                <i data-feather="user"></i>
                                                <span>Profile</span>
                                            </a>
                                        </li>--}}
                                        <li class="nav-item">
                                            <a href="{{route('logout')}}" class="nav-link">
                                                <i data-feather="log-out"></i>
                                                <span>Log Out</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="page-content">
                @include('layouts.msg.msg-layout')
                @yield('content')
                @include('sweetalert::alert')

            </div>
            <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between">
                <p class="text-muted text-center text-md-left">Copyright © {{date('Y')}} <a href="https://www.prodesigner.lk"
                        target="_blank">Prodesigner Global</a>. All rights reserved</p>
                <p class="text-muted text-center text-md-left mb-0 d-none d-md-block">v{{ config('app.version') }}</p>
            </footer>
        </div>
    </div>

    <script src="{{ url('assets/js/select2.js') }}"></script>
    <script src="{{ url('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ url('assets/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ url('assets/vendors/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ url('assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ url('assets/vendors/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
    <script src="{{ url('assets/vendors/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ url('assets/vendors/dropify/dist/dropify.min.js') }}"></script>
    <script src="{{ url('assets/vendors/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ url('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ url('assets/vendors/moment/moment.min.js') }}"></script>
    <script src="{{ url('assets/vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
    <script src="{{ url('assets/vendors/feather-icons/feather.min.js') }}"></script>
    <script src="{{ url('assets/js/template.js') }}"></script>
    <script src="{{ url('assets/js/form-validation.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap-maxlength.js') }}"></script>
    <script src="{{ url('assets/js/inputmask.js') }}"></script>
    <script src="{{ url('assets/js/typeahead.js') }}"></script>
    <script src="{{ url('assets/js/file-upload.js') }}"></script>
    <script src="{{ url('assets/js/tags-input.js') }}"></script>
    <script src="{{ url('assets/js/dropzone.js') }}"></script>
    <script src="{{ url('assets/js/dropify.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ url('assets/js/datepicker.js') }}"></script>
    <script src="{{ url('assets/js/timepicker.js') }}"></script>
    <script src="{{ url('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ url('assets/vendors/promise-polyfill/polyfill.min.js') }}"></script>
    <script src="{{ url('assets/js/sweet-alert.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ url('assets/vendors/jquery-steps/jquery.steps.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <script src="{{ url('assets/vendors/jquery-validation/jquery.validate.min.js') }}"></script>

    <script src="{{url('assets/js/Custom/leads.js')}}"></script>
    <script src="{{url('assets/js/Custom/notification.js')}}"></script>
    <script src="{{ url('assets/js/Custom/studentInformation.js') }}"></script>


    @stack('scripts')
</body>
<script>
    $('document').ready(function(){
        $('.search-body').slideUp();
        $('.search-header').click(function () {
            $('.search-body').slideToggle();
            $('.action-body').slideToggle();
        });
        $('.action-header').click(function () {
            $('.search-body').slideToggle();
            $('.action-body').slideToggle();
        });
    });
    $('#regular-table').DataTable({
        "bSortClasses": false,

        dom: 'Bfrtip',
        lengthMenu: [
            [10, 50, 100, 500, 1000, 5000, -1],
            ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows', '5000 rows', 'Show all']
        ],
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],
        order: [
            [
                0, "desc"
            ]
        ],
    });

    /**
     *
     * @param type
     * @param msg
     */
    function notify(type, msg) {
        Swal.fire({
            toast: true,
            timerProgressBar: true,
            position: 'top',
            icon: type,
            title: msg,
            showConfirmButton: false,
            timer: 2500
        })
    }
</script>

</html>
