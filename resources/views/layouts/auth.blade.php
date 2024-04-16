<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Find Housing</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />

    @isset($HeadSource)
        @foreach ($HeadSource as $item)
            <link rel="stylesheet" href="{{ $item }}">
        @endforeach
    @endisset

    {{-- styles --}}
    @stack('styles')
</head>

<body>
    <!--  Body Wrapper -->
    @yield('content')

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

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
