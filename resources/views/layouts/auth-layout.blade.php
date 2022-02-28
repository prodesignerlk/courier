<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name')}}</title>
    <link rel="stylesheet" href="{{url('assets/vendors/core/core.css')}}">
    <link rel="stylesheet" href="{{url('assets/fonts/feather-font/css/iconfont.css')}}">
    <link rel="stylesheet" href="{{url('assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/demo_1/style.css')}}">
    <link rel="shortcut icon" href="{{url('assets/images/favicon.png')}}" />
</head>

<body class="sidebar-dark">
    <div class="main-wrapper">
        @yield('content')
        
    </div>
    <script src="{{url('assets/vendors/core/core.js')}}"></script>
    <script src="{{url('assets/vendors/feather-icons/feather.min.js')}}"></script>
    <script src="{{url('assets/js/template.js')}}"></script>
</body>

</html>