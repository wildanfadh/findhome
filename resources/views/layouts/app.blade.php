<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SPK Find Housing</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/dist/simplebar.css') }}"> --}}

    @isset($HeadSource)
        @foreach ($HeadSource as $item)
            <link rel="stylesheet" href="{{ $item }}">
        @endforeach
    @endisset

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
