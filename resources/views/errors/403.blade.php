<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Findhousing - 403</title>

    <link rel="stylesheet" href="{{ asset('assets/css/custom_error.css') }}">
</head>

<body>
    <div class="scene">
        <div class="overlay"></div>
        <div class="overlay"></div>
        <div class="overlay"></div>
        <div class="overlay"></div>
        <span class="bg-403">403</span>
        <div class="text">
            <span class="hero-text"></span>
            <span class="msg">Pengguna tidak memiliki peran yang tepat.</span>
            <span class="support">
                {{-- <span>unexpected?</span> --}}
                <a type="button" onclick="history.back()">Kembali</a>
            </span>
        </div>
        <div class="lock"></div>
    </div>

</body>

</html>
