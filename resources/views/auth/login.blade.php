@extends('layouts.auth')

@push('styles')
    <style>
        #password_icon {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="{{ url('/') }}" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('assets/images/logos/new_logo.png') }}" width="180"
                                        alt="">
                                </a>
                                {{-- <p class="text-center">Your Social Campaigns</p> --}}
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="username"
                                            aria-describedby="emailHelp">
                                    </div>
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" id="password">
                                            <span class="input-group-text" id="password_icon"><i
                                                    class="ti ti-lock fs-6"></i></span>
                                        </div>
                                    </div>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    <button type="submit"
                                        class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Masuk</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">belum punya Akun?</p>
                                        <a class="text-primary fw-bold ms-2" href="{{ route('register') }}">buat
                                            Akun</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '#password_icon', function() {
            var password_input = $(this).prev('input');
            var passIcon = $(this).find("i").attr('class');

            console.log(password_input, passIcon);

            if (passIcon == 'ti ti-lock fs-6') {
                password_input.attr('type', 'text');
                $(this).find("i").attr('class', 'ti ti-eye fs-6');
            } else {
                password_input.attr('type', 'password');
                $(this).find("i").attr('class', 'ti ti-lock fs-6');
            }
        });
    </script>
@endpush
