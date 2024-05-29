<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
    <!-- initiate head with meta tags, css and script -->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('storage/setting/favicon/'.$setting->favicon) }}"/>

    <!-- font awesome library -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <script src="{{ asset('js/app.js') }}" ></script>
    {{-- <script src="{{ asset('css/app.css') }}" defer></script> --}}

    
    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <!-- themekit admin template asstes -->
    <link rel="stylesheet" href="{{ asset('backend/all.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/theme.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/icon-kit/dist/css/iconkit.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/ionicons/dist/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert/sweetalert.css') }}"/>
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/custom.css')}}">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <style type="text/css">
        .btn{
            padding: 5px 14px !important;
        }

        .btn-sm{
            padding: 3px 6px !important;
            font-size: 11px !important;
            height: 24px !important;
        }

        .btn-success{
            background-color: #28a745;
            border: 1px solid #28a745;
        }

        .badge-success{
            background-color: #28a745;
        }

    </style>
    @stack('style')
</head>
<body id="app">
<div class="wrapper">
    <!-- initiate header-->
    @include('backend.layouts.header')
    <div class="page-wrap">
        <!-- initiate sidebar-->
        @include('backend.layouts.sidebar')
        <div class="main-content">
            <!-- yeild contents here -->
            @yield('content')
        </div>
        <!-- initiate footer section-->
        @include('backend.layouts.footer')
    </div>
</div>

<div id="modal-loader" >
    <div class="loadingio-spinner-eclipse-5n5ocxxlhe2">
        <div class="ldio-shhdvnglxrk">
            <div></div>
        </div>
    </div>
</div>

<!-- initiate scripts-->
<script src="{{ asset('backend/all.js') }}"></script>
<!-- Stack array for including inline js or scripts -->
<script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('backend/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('backend/js/layouts.js') }}"></script>
<script src="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>
<script src="{{ asset('backend/dist/js/theme.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>

<script>
    (function($) {
        showNotification = function(title, subtitle, type, position) {
            'use strict';
            resetToastPosition();

            var toastConfig = {
                                 "success":{
                                      "icon":"success",
                                      "bg":"#f96868"
                                  },
                                  "info":{
                                      "icon":"info",
                                      "bg":"#46c35f"
                                  },
                                  "warning":{
                                      "icon":"warning",
                                      "bg":"#57c7d4"
                                  },
                                  "danger":{
                                      "icon":"error",
                                      "bg":"#f2a654"
                                  }
                              };

            $.toast({
                heading: String(title),
                text: String(subtitle),
                position: String(position),
                icon: String(toastConfig[type]['icon']),
                loaderBg: String(toastConfig[type]['bg']),
                hideAfter: 4e3,
            })
        }
        resetToastPosition = function() {
            $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center'); 
            $('.jq-toast-wrap').removeClass('bottom-left bottom-right top-left top-right mid-center');
            $(".jq-toast-wrap").css({
                "top": "",
                "left": "",
                "bottom": "",
                "right": ""
            }); 
        }

        

    })(jQuery);

</script>

@stack('script')

@if (session('status'))

    <script> showNotification('Success!','{{ session('status') }}', 'success', 'top-right'); </script>

@elseif (session('error'))
    <script> showNotification('Error!','{{ session('error') }}', 'danger', 'top-right'); </script>

@elseif (session('log_status'))
    <script> showNotification('','{{ session('log_status') }}', 'danger', 'top-right'); </script>

@elseif (session("parent_status"))
    <script> showNotification('{{ session("parent_status")["primary"] }}','{{ session("parent_status")["secondary"] }}', 'danger', 'top-right'); </script>

@endif

@if ($errors->any())
    @foreach ($errors->all() as $key=>$error)

        <script> showNotification('','{{ $error }}', 'danger', 'top-right'); </script>
        
    @endforeach
@endif
</body>
</html>

