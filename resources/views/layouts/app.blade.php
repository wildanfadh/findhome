<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK Find Housing</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/dist/simplebar.css') }}"> --}}

    <style>
        .page-wrapper {
            height: 100% !important;
        }

        .body-wrapper {}
    </style>

    @isset($HeadSource)
        @foreach ($HeadSource as $item)
            <link rel="stylesheet" href="{{ $item }}">
        @endforeach
    @endisset

    <style>
        .required-symbol {
            color: red;
            font-size: 1rem;
        }

        /* DEMO-SPECIFIC STYLES */
        .typewriter {
            color: #fff;
            font-family: monospace;
            overflow: hidden;
            /* Ensures the content is not revealed until the animation */
            border-right: .15em solid orange;
            /* The typwriter cursor */
            white-space: nowrap;
            /* Keeps the content on a single line */
            margin: 0 auto;
            /* Gives that scrolling effect as the typing happens */
            letter-spacing: .15em;
            /* Adjust as needed */
            animation:
                typing 3.5s steps(30, end),
                blink-caret .5s step-end infinite;
        }

        /* The typing effect */
        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        /* The typewriter cursor effect */
        @keyframes blink-caret {

            from,
            to {
                border-color: transparent
            }

            50% {
                border-color: orange
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('layouts.components.app.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('layouts.components.app.navbar')
            <!--  Header End -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    {{-- <script src="../assets/libs/simplebar/dist/simplebar.js"></script> --}}
    {{-- <script src="{{ asset('assets/libs/simplebar/src/simplebar.js') }}"></script> --}}
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>

    @isset($JsSource)
        @foreach ($JsSource as $item)
            <script src="{{ $item }}"></script>
        @endforeach
    @endisset

    <script>
        function objectToArray(data) {
            return Object.keys(data).map((key) => [key, data[key]]);
        }
    </script>

    {{-- js pages --}}
    @stack('scripts')

</body>

</html>
