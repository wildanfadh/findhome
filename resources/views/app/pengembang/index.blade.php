@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Daftar Pengembang</h5>
            {{-- <p class="mb-0">This is a sample page</p> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pengembang Terdaftar</h5>
                </div>
                <div class="card-body">
                    <table id="pengembangTable" class="table">
                        <thead>
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">Nama</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Email</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            {{-- ----------------------------- Datatables ----------------------------- --}}
            var url = `{!! route('ajax.user.pengembang') !!}`;
            var table = $('#pengembangTable').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                ajax: url,
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'name',
                    name: 'name'
                }, {
                    data: 'no_hp',
                    name: 'no_hp'
                }, {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'alamat',
                    name: 'alamat'
                }, {
                    data: 'action',
                    name: 'action'
                }],
            });
            {{-- ----------------------------- Datatables ----------------------------- --}}

            {{-- ------------------------- Active and Inactive ------------------------ --}}
            // Active to Active
            $(document).on('click', '.btn-active', function() {

                let data = $(this).data('single_source');
                console.log(data);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ url('ajax.user/active_nonactive') }}/` + data.id;

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        is_active: 0
                    },
                    dataType: 'json',
                    timeout: 5000,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#penggunaTable').block();
                    },
                }).done(function(data, textStatus, jqXHR) {
                    // Process data, as received in data parameter

                    // Send warning log message if response took longer than 2 seconds
                    var msAfterAjaxCall = new Date().getTime();
                    var timeTakenInMs = msAfterAjaxCall - msBeforeAjaxCall;
                    if (timeTakenInMs > 2000) {
                        Swal.fire({
                            toast: true,
                            title: "Warning!",
                            text: "AJAX response takes a long time.",
                            icon: "warning"
                        });
                    } else {
                        // show success message
                        // Swal.fire({
                        //     toast: true,
                        //     title: "Berhasil!",
                        //     text: data.message,
                        //     icon: "success"
                        // });
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
                    table.draw();
                    $('#penggunaTable').unblock();
                });
            });

            // Inactive to Active
            $(document).on('click', '.btn-inactive', function() {

                let data = $(this).data('single_source');
                console.log(data);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ url('ajax.user/active_nonactive') }}/` + data.id;

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        is_active: 1
                    },
                    dataType: 'json',
                    timeout: 5000,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#penggunaTable').block();
                    },
                }).done(function(data, textStatus, jqXHR) {
                    // Process data, as received in data parameter

                    // Send warning log message if response took longer than 2 seconds
                    var msAfterAjaxCall = new Date().getTime();
                    var timeTakenInMs = msAfterAjaxCall - msBeforeAjaxCall;
                    if (timeTakenInMs > 2000) {
                        Swal.fire({
                            toast: true,
                            title: "Warning!",
                            text: "AJAX response takes a long time.",
                            icon: "warning"
                        });
                    } else {
                        // show success message
                        // Swal.fire({
                        //     toast: true,
                        //     title: "Berhasil!",
                        //     text: data.message,
                        //     icon: "success"
                        // });
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
                    table.draw();
                    $('#penggunaTable').unblock();
                });
            });
            {{-- ------------------------- Active and Inactive ------------------------ --}}
        });
    </script>
@endpush
