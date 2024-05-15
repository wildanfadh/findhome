@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Master Data Kriteria</h5>
            <p class="mb-0">This is a sample page </p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">Daftar Kriteria</h5>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary float-end" id="tambahKriteria" data-bs-toggle="modal"
                                data-bs-target="#tambahModal">Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="kriteriaTable" class="table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Nama</th>
                                <th>Sifat</th>
                                <th>Bobot</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambah  Modal -->
    <div class="modal fade" id="tambahModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah Kriteria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahKriteria" autocomplete="off">
                        @csrf

                        <div class="mb-3">
                            <label for="inputTambahNama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" id="inputTambahNama"
                                placeholder="nama kriteria" @required(true)>
                        </div>

                        <div class="mb-3">
                            <label for="selectTambahSifat" class="form-label">Sifat</label>
                            <select name="sifat" class="form-select" id="selectTambahSifat" @required(true)>
                                @foreach (App\Enums\SifatKriteria::asSelectArray() as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="inputTambahBobot" class="form-label">Bobot</label>
                            <input type="number" name="bobot" class="form-control" id="inputTambahBobot"
                                placeholder="bobot kriteria dalam persentase" @required(true)>
                        </div>

                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Edit  Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Kriteria ( <span id="editTitle"></span> )</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditKriteria" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" id="inputEditId">
                        <div class="mb-3">
                            <label for="inputEditNama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" id="inputEditNama"
                                placeholder="nama kriteria" @required(true)>
                        </div>

                        <div class="mb-3">
                            <label for="selectEditSifat" class="form-label">Sifat</label>
                            <select name="sifat" class="form-select" id="selectEditSifat" @required(true)>
                                @foreach (App\Enums\SifatKriteria::asSelectArray() as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditBobot" class="form-label">Bobot</label>
                            <input type="number" name="bobot" class="form-control" id="inputEditBobot"
                                placeholder="bobot kriteria dalam persentase" @required(true)>
                        </div>

                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            {{-- ----------------------------- Datatables ----------------------------- --}}
            var url = `{!! route('ajax.kriteria.index') !!}`;
            var table = $('#kriteriaTable').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                ajax: url,
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'nama',
                    name: 'nama'
                }, {
                    data: 'sifat',
                    name: 'sifat'
                }, {
                    data: 'bobot',
                    name: 'bobot'
                }, {
                    data: 'action',
                    name: 'action'
                }],
            });
            {{-- ----------------------------- Datatables ----------------------------- --}}


            {{-- --------------------------- Tambah Function -------------------------- --}}
            $('#tambahKriteria').click(function() {
                // console.log('tambah kriteria:');
                $('#formTambahKriteria').trigger('reset');
            });

            $('#formTambahKriteria').submit(function(e) {
                e.preventDefault();
                console.log('form submit');

                var formData = $(this).serialize();
                console.log('formData:', formData);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ route('ajax.kriteria.store') }}`;

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    timeout: 5000,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#kriteriaTable').block();
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
                        Swal.fire({
                            toast: true,
                            title: "Berhasil!",
                            text: data.message,
                            icon: "success"
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
                    $('#formTambahKriteria').trigger('reset');
                    $('#tambahModal').modal('hide');
                    table.draw();
                    $('#kriteriaTable').unblock();
                });
            });
            {{-- --------------------------- Tambah Function -------------------------- --}}

            {{-- --------------------------- Update Function -------------------------- --}}
            $(document).on('click', '.edit', function() {
                console.log('edit kriteria:');
                $('#editModal').modal('show');

                let data = $(this).data('single_source');
                console.log(data);

                $('#editTitle').html(data.nama);
                $('#inputEditId').val(data.id);
                $('#inputEditNama').val(data.nama);
                $('#selectEditSifat').val(data.sifat);
                $('#inputEditBobot').val(data.bobot);
            });

            $(document).on('submit', '#formEditKriteria', function(e) {
                e.preventDefault();
                console.log('form submit');
                var id = $('#inputEditId').val();
                var formData = $(this).serialize();
                console.log('formData:', formData);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ url('ajax.kriteria/update') }}/` + id;
                // url.replaceAll('{idKriteria}', id);
                console.log(url);

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    timeout: 5000,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#kriteriaTable').block();
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
                        Swal.fire({
                            toast: true,
                            title: "Berhasil!",
                            text: data.message,
                            icon: "success"
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
                    $('#formEditKriteria').trigger('reset');
                    $('#editModal').modal('hide');
                    table.draw();
                    $('#kriteriaTable').unblock();
                });
            });
            {{-- --------------------------- Update Function -------------------------- --}}

            {{-- --------------------------- Delete Function -------------------------- --}}
            $(document).on('click', '.delete', function() {
                console.log('delete kriteria:');

                let data = $(this).data('single_source');
                console.log(data);


                Swal.fire({
                    toast: true,
                    title: "Apakah anda yakin?",
                    text: "Anda akan menghapus data ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        // required for ajax request
                        var msBeforeAjaxCall = new Date().getTime();

                        var url = `{{ url('ajax.kriteria/delete') }}/` + data.id;
                        // url.replaceAll('{idKriteria}', id);
                        console.log(url);

                        $.ajax({
                            type: 'DELETE',
                            url: url,
                            data: {
                                "_token": `{{ csrf_token() }}`,
                            },
                            dataType: 'json',
                            timeout: 5000,
                            beforeSend: function() {
                                // show spinner or loader
                                $('#kriteriaTable').block();
                            },
                        }).done(function(data, textStatus, jqXHR) {
                            // Process data, as received in data parameter

                            // Send warning log message if response took longer than 2 seconds
                            var msAfterAjaxCall = new Date().getTime();
                            var timeTakenInMs = msAfterAjaxCall - msBeforeAjaxCall;
                            if (timeTakenInMs > 2000) {
                                // alert('AJAX response takes a long time');
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
                                    title: "Terhapus!",
                                    text: "Data sudah terhapus.",
                                    icon: "success"
                                });
                            }
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            // Request failed. Show error message to user.
                            // errorThrown has error message, or 'timeout' in case of timeout.
                            Swal.fire({
                                toast: true,
                                title: "Gagal!",
                                text: "Data gagal terhapus.",
                                icon: "danger"
                            });
                        }).always(function(jqXHR, textStatus, errorThrown) {
                            // Hide spinner or loader
                            $('#kriteriaTable').unblock();
                            table.draw();
                        });

                    }
                });

            });
            {{-- --------------------------- Delete Function -------------------------- --}}
        });
    </script>
@endpush
