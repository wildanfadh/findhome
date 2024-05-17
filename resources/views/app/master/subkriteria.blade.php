@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Master Data Sub Kriteria ( <span>{{ $data->nama }}</span> ) </h5>
            {{-- <p class="mb-0">This is a sample page </p> --}}
            <button onclick="history.back()" class="btn btn-primary"><i class="ti ti-arrow-back-up"></i>
                Kembali</button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">Daftar Sub Kriteria</h5>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary float-end" id="tambahSubKriteria" data-bs-toggle="modal"
                                data-bs-target="#tambahModal">Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="subKriteriaTable" class="table">
                        <thead>
                            <tr class="text-start">
                                <th>NO</th>
                                <th>Uraian</th>
                                <th>Nilai</th>
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
                    <h1 class="modal-title fs-5" id="tambahModalLabel">Tambah Sub Kriteria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahSubKriteria" autocomplete="off">
                        @csrf

                        <input type="hidden" name="kriteria_id" value="{{ $data->id }}">

                        <div class="mb-3">
                            <label for="inputTambahUraianSK" class="form-label">Uraian</label>
                            <input type="text" name="uraian" class="form-control" id="inputTambahUraianSK"
                                placeholder="uraian sub kriteria" @required(true)>
                        </div>

                        <div class="mb-3">
                            <label for="inputTambahNilaiSK" class="form-label">Nilai</label>
                            <input type="number" name="nilai" class="form-control" id="inputTambahNilaiSK"
                                placeholder="nilai sub kriteria" @required(true)>
                            <div id="inputTambahNilaiSKHelp" class="form-text">Berikan nilai dalam angka.</div>
                        </div>

                        <button type="submit" class="btn btn-primary float-end" id="simpanBtnSubKriteria">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit  Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Sub Kriteria ( <span id="editTitle"></span> )
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditSubKriteria" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" id="inputEditId" value="">
                        <input type="hidden" name="kriteria_id" value="{{ $data->id }}">

                        <div class="mb-3">
                            <label for="inputEditUraianSK" class="form-label">Uraian</label>
                            <input type="text" name="uraian" class="form-control" id="inputEditUraianSK"
                                placeholder="uraian sub kriteria" @required(true)>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditNilaiSK" class="form-label">Nilai</label>
                            <input type="number" name="nilai" class="form-control" id="inputEditNilaiSK"
                                placeholder="nilai sub kriteria" @required(true)>
                            <div id="inputEditNilaiSKHelp" class="form-text">Berikan nilai dalam angka.</div>
                        </div>

                        <button type="submit" class="btn btn-primary float-end"
                            id="simpanEditBtnSubKriteria">Simpan</button>
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
            var url = `{!! url('ajax.subkriteria/data_by_kriteria') . '/' . $data->id !!}`;
            var table = $('#subKriteriaTable').DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                searching: false,
                // info: false,
                ordering: false,
                // paging: false,
                ajax: url,
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'uraian',
                    name: 'uraian'
                }, {
                    data: 'nilai',
                    name: 'nilai'
                }, {
                    data: 'action',
                    name: 'action'
                }],
            });
            {{-- ----------------------------- Datatables ----------------------------- --}}

            {{-- --------------------------- Tambah Function -------------------------- --}}
            $('#tambahSubKriteria').click(function() {
                // console.log('tambah kriteria:');
                $('#formTambahSubKriteria').trigger('reset');
            });

            $('#formTambahSubKriteria').submit(function(e) {
                e.preventDefault();
                console.log('form submit');

                var formData = $(this).serialize();
                console.log('formData:', formData);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ route('ajax.subkriteria.store') }}`;

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    timeout: 5000,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#subKriteriaTable').block();
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
                    $('#formTambahSubKriteria').trigger('reset');
                    $('#tambahModal').modal('hide');
                    table.draw();
                    $('#subKriteriaTable').unblock();
                });
            });
            {{-- --------------------------- Tambah Function -------------------------- --}}

            {{-- --------------------------- Update Function -------------------------- --}}
            $(document).on('click', '.edit-sub', function() {
                console.log('edit sub kriteria:');
                $('#editModal').modal('show');

                let data = $(this).data('single_source');
                console.log(data);

                $('#editTitle').html(data.uraian);
                $('#inputEditId').val(data.id);
                $('#inputEditUraianSK').val(data.uraian);
                $('#inputEditNilaiSK').val(data.nilai);
            });

            $(document).on('submit', '#formEditSubKriteria', function(e) {
                e.preventDefault();
                console.log('form submit');
                var id = $('#inputEditId').val();
                var formData = $(this).serialize();
                console.log('formData:', formData);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ url('ajax.subkriteria/update') }}/` + id;
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
                        $('#subKriteriaTable').block();
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
                    $('#formEditSubKriteria').trigger('reset');
                    $('#editModal').modal('hide');
                    table.draw();
                    $('#subKriteriaTable').unblock();
                });
            });
            {{-- --------------------------- Update Function -------------------------- --}}

            {{-- --------------------------- Delete Function -------------------------- --}}
            $(document).on('click', '.delete-sub', function() {
                console.log('delete sub kriteria:');

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

                        var url = `{{ url('ajax.subkriteria/delete') }}/` + data.id;
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
                                $('#subKriteriaTable').block();
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
                            $('#subKriteriaTable').unblock();
                            table.draw();
                        });

                    }
                });

            });
            {{-- --------------------------- Delete Function -------------------------- --}}
        });
    </script>
@endpush
