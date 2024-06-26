@extends('layouts.auth')

@push('styles')
    <style>
        #password_icon,
        #password_conf_icon {
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
                                <form id="form_registrasi" autocomplete="off">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control" id="nama"
                                            aria-describedby="namaHelp" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="username"
                                            aria-describedby="usernameHelp" required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="no_hp" class="form-label">No HP</label>
                                        <input type="number" name="no_hp" class="form-control" id="no_hp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" id="password"
                                                required>
                                            <span class="input-group-text" id="password_icon"><i
                                                    class="ti ti-lock fs-6"></i></span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_conf" class="form-label">Konfirmasi Password</label>
                                        <div class="input-group">
                                            <input type="password" name="password_conf" class="form-control"
                                                id="password_conf" required>
                                            <span class="input-group-text" id="password_conf_icon"><i
                                                    class="ti ti-lock fs-6"></i></span>
                                        </div>
                                    </div>
                                    <button type="button"
                                        class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2 daftar">Daftar</button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">sudah punya Akun?</p>
                                        <a class="text-primary fw-bold ms-2" href="{{ route('login') }}">Masuk</a>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        {{-- <p class="fs-4 mb-0 fw-bold">daftar sebagai pengembang?</p> --}}
                                        <a class="text-primary fw-bold ms-2"
                                            href="{{ route('page.user.register_pengembang') }}">daftar sebagai
                                            Pengembang</a>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {

            {{-- ------------------------------ variables ----------------------------- --}}
            var form_registrasi = $('#form_registrasi');
            {{-- ------------------------------ variables ----------------------------- --}}

            {{-- --------------------------- form validation -------------------------- --}}
            form_registrasi.validate();
            {{-- --------------------------- form validation -------------------------- --}}

            {{-- -------------------------- password control -------------------------- --}}
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

            $(document).on('click', '#password_conf_icon', function() {
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
            {{-- -------------------------- password control -------------------------- --}}

            {{-- ---------------------------- registration ---------------------------- --}}
            $('.daftar').on('click', function(e) {
                // e.preventDevault();
                var nama = $("input[name='nama']").val();
                var username = $("input[name='username']").val();
                var no_hp = $("input[name='no_hp']").val();
                var email = $("input[name='email']").val();
                var password = $("input[name='password']").val();
                var password_conf = $("input[name='password_conf']").val();
                var data = {
                    _token: `{{ csrf_token() }}`,
                    name: nama,
                    username: username,
                    no_hp: no_hp,
                    email: email,
                    password: password,
                    password_confirmation: password_conf,
                };
                console.log(data);


                // console.log('form registrasi');
                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ route('register_umum') }}`;

                $.ajax({
                    type: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    timeout: 5000,
                    beforeSend: function() {
                        // show spinner or loader
                        form_registrasi.block();
                    },
                }).done(function(data, textStatus, jqXHR) {
                    // Process data, as received in data parameter

                    // Send warning log message if response took longer than 10 seconds
                    var msAfterAjaxCall = new Date().getTime();
                    var timeTakenInMs = msAfterAjaxCall - msBeforeAjaxCall;
                    if (timeTakenInMs > 10000) {
                        Swal.fire({
                            toast: true,
                            title: "Warning!",
                            text: "AJAX response takes a long time.",
                            icon: "warning"
                        });
                    } else {
                        // show success message
                        Swal.fire({
                            toast: true,
                            title: "Berhasil!",
                            text: data.message,
                            icon: "success",
                            timer: 1000,
                            showConfirmButton: false
                        });
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    // Request failed. Show error message to user.
                    // errorThrown has error message, or 'timeout' in case of timeout.
                    var errors = objectToArray(jqXHR.responseJSON
                        .errors);

                    return errors.forEach(element => {
                        Swal.fire({
                            toast: true,
                            title: "Gagal!",
                            text: element[1][0],
                            icon: "danger"
                        });
                    });
                }).always(function(jqXHR, textStatus, errorThrown) {
                    // Hide spinner or loader
                    if (textStatus == 'success') {
                        form_registrasi.unblock();
                        window.location.href = "{{ route('login') }}";
                    }

                });

            });
            {{-- ---------------------------- registration ---------------------------- --}}
        });
    </script>
@endpush
