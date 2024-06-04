@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">My Profile</h5>
            {{-- <p class="mb-0">This is a sample page </p> --}}
            <div class="row">
                <div class="col-6">
                    <form id="form_myprofile">
                        @csrf
                        @method('PUT')

                        {{-- <input type="hidden" name="id" value="{!! auth()->user()->id !!}"> --}}

                        <div class="mb-3">
                            <label for="inputNama" class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control" id="inputNama"
                                placeholder="nama lengkap" @required(true) value="{!! auth()->user()->name !!}">
                        </div>

                        <div class="mb-3">
                            <label for="inputUsername" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="inputUsername"
                                placeholder="username" @required(true) value="{!! auth()->user()->username !!}">
                        </div>

                        <div class="mb-3">
                            <label for="inputNoHp" class="form-label">No Hp</label>
                            <input type="text" name="no_hp" class="form-control" id="inputNoHp" placeholder="username"
                                @required(true) value="{!! auth()->user()->no_hp !!}">
                        </div>

                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="email"
                                @required(true) value="{!! auth()->user()->email !!}">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            {{-- ----------------------- UPDATE PROFILE FUNCTION ---------------------- --}}
            $('#form_myprofile').on('submit', function(e) {
                e.preventDefault();
                console.log('form submit');

                let formData = $(this).serialize();
                // console.log(formData);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ route('ajax.user.update', auth()->user()->id) }}`;

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    timeout: 5000,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#form_myprofile').block();
                    },
                }).done(function(data, textStatus, jqXHR) {
                    // Process data, as received in data parameter

                    // Send warning log message if response took longer than 2 seconds
                    var msAfterAjaxCall = new Date().getTime();
                    var timeTakenInMs = msAfterAjaxCall - msBeforeAjaxCall;
                    if (timeTakenInMs > 10000) {
                        alert('AJAX response takes a long time');
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
                            icon: "danger",
                            timer: 1000,
                            showConfirmButton: false
                        });
                    });
                }).always(function(jqXHR, textStatus, errorThrown) {
                    // Hide spinner or loader
                    $('#form_myprofile').unblock();
                    if (textStatus == 'success') {}
                });
            })
            {{-- ----------------------- UPDATE PROFILE FUNCTION ---------------------- --}}

        });
    </script>
@endpush
