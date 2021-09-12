<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'app-name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">

    <!-- inject:css-->

    @yield('css-plugins')

    <link rel="stylesheet" href="{{ asset('template/css/plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('template/style.css') }}">

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .dt-body-right {
            text-align: right;
        };

        .dt-body-left {
            text-align: left;
        };

        .dt-body-center {
            text-align: center;
        };
    </style>

    @yield('custom-css')
    <!-- endinject -->

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/img/favicon.png') }}">
</head>

<body class="layout-light side-menu overlayScroll">

    @include('layouts.includes.header')
    <main class="main-content">

        @include('layouts.includes.sidebar')

        <div class="contents">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>

        @include('layouts.includes.footer')
    </main>

    <div id="overlayer">
        <span class="loader-overlay">
            <div class="atbd-spin-dots spin-lg">
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
            </div>
        </span>
    </div>
    {{-- <a href="#" class="customizer-trigger">
        <span data-feather="settings"></span></a>
    <div class="customizer-wrapper">
        <div class="customizer">
            <div class="customizer__head">
                <h4 class="customizer__title">Customizer</h4>
                <span class="customizer__sub-title">Customize your overview page layout</span>
                <a href="#" class="customizer-close">
                    <span data-feather="x"></span></a>
            </div>
            <div class="customizer__body">
                <div class="customizer__single">
                    <h4>Layout Type</h4>
                    <ul class="customizer-list d-flex layout">
                        <li class="customizer-list__item">
                            <a href="https://demo.jsnorm.com/html/strikingdash/strikingdash/ltr" class="active">
                                <img src="{{ asset('template/img/ltr.png') }}" alt="">
                                <i class="fa fa-check-circle"></i>
                            </a>
                        </li>
                        <li class="customizer-list__item">
                            <a href="https://demo.jsnorm.com/html/strikingdash/strikingdash/rtl" class="">
                                <img src="{{ asset('template/img/rtl.png') }}" alt="">
                                <i class="fa fa-check-circle"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- ends: .customizer__single -->

                <div class="customizer__single">
                    <h4>Sidebar Type</h4>
                    <ul class="customizer-list d-flex l_sidebar">
                        <li class="customizer-list__item">
                            <a href="#" data-layout="light" class="active">
                                <img src="{{ asset('template/img/light.png') }}" alt="">
                                <i class="fa fa-check-circle"></i>
                            </a>
                        </li>
                        <li class="customizer-list__item">
                            <a href="#" data-layout="dark">
                                <img src="{{ asset('template/img/dark.png') }}" alt="">
                                <i class="fa fa-check-circle"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- ends: .customizer__single -->

                <div class="customizer__single">
                    <h4>Navbar Type</h4>
                    <ul class="customizer-list d-flex l_navbar">
                        <li class="customizer-list__item">
                            <a href="#" data-layout="side" class="active">
                                <img src="{{ asset('template/img/side.png') }}" alt="">
                                <i class="fa fa-check-circle"></i>
                            </a>
                        </li>
                        <li class="customizer-list__item top">
                            <a href="#" data-layout="top">
                                <img src="{{ asset('template/img/top.png') }}" alt="">
                                <i class="fa fa-check-circle"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- ends: .customizer__single -->
            </div>
        </div>
    </div> --}}
    <div class="overlay-dark-sidebar"></div>
    <div class="customizer-overlay"></div>

    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDduF2tLXicDEPDMAtC6-NLOekX0A5vlnY"></script>
    <!-- inject:js-->
    <script src="{{ asset('template/js/plugins.min.js') }}"></script>
    @yield('js-plugins')
    <script src="{{ asset('template/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('template/js/axios.min.js') }}"></script>
    <script src="{{ asset('template/js/script.min.js') }}"></script>
    <script src="https://cdn.socket.io/3.1.3/socket.io.min.js" integrity="sha384-cPwlPLvBTa3sKAgddT6krw0cJat7egBga3DJepJyrLl4Q9/5WLra3rrnMcyTyOnh" crossorigin="anonymous"></script>
    <script>
        $('[data-toggle=tooltip]' ).on('mouseleave', function( e ){
            $(this).tooltip('hide');
        });

        var socket = io.connect('http://192.168.254.101:3000', { transports : ['websocket'] });
    </script>

    @yield('custom-js')
    <!-- endinject-->
</body>

</html>
