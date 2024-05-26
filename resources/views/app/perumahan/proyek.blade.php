@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Proyek Perumahan</h5>
            {{-- <p class="mb-0">This is a sample page</p> --}}
            {{-- <div class="mt-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#tambahModal">Tambah</button>
            </div> --}}
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-3">
            <div class="card">
                <img src="../assets/images/products/s4.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                        the
                        card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">Daftar Proyek Perumahan</h5>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary float-end" id="tambahPerumahan" data-bs-toggle="modal"
                                data-bs-target="#tambahModal">Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="perumahanTable" class="table">
                        <thead>
                            <tr class="text-start">
                                <th>NO</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tambah Modal -->
    <div class="modal fade" id="tambahModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="tambahModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahModalLabel">Pengajuan Proyek Perumahan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahPerumahan" action="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="inputName" class="form-label">Nama<span class="required-symbol">*</span></label>
                            <input type="text" name="nama" class="form-control" id="inputName"
                                aria-describedby="nameHelp" @required(true)>
                        </div>

                        <div class="mb-3">
                            <label for="inputAlamat" class="form-label">Alamat<span class="required-symbol">*</span></label>
                            <textarea name="alamat" class="form-control" id="inputAlamat" rows="3" @required(true)></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="inputKeterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="inputKeterangan"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="inputGambar" class="form-label">Gambar<span class="required-symbol">*</span></label>
                            <input name="gambar" type="file" class="form-control" id="inputGambar" accept="image/*"
                                @required(true)>
                        </div>

                        <button type="submit" class="btn btn-primary float-end">Simpan dan Ajukan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit Data Proyek Perumahan ( <span
                            id="editTitle"></span> )</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="https://placehold.co/600x400" alt="image_perumahan" id="imagePerumahanViewEdit"
                        style="width: 100%">
                    <form id="formEditPerumahan" class="mt-5" enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}

                        <input type="hidden" name="id" id="inputEditPerumahanId">

                        <div class="mb-3">
                            <label for="inputEditName" class="form-label">Nama<span
                                    class="required-symbol">*</span></label>
                            <input type="text" name="nama" class="form-control" id="inputEditName"
                                aria-describedby="nameHelp" @required(true)>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditAlamat" class="form-label">Alamat<span
                                    class="required-symbol">*</span></label>
                            <textarea name="alamat" class="form-control" id="inputEditAlamat" rows="3" @required(true)></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditKeterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="inputEditKeterangan"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditGambar" class="form-label">Gambar</label>
                            <input name="gambar" type="file" class="form-control" id="inputEditGambar"
                                accept="image/*">
                            <div id="editGambarHelp" class="form-text">Upload gambar akan menimpa gambar yang sudah ada.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary float-end">Simpan dan Ajukan</button>
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
            var url = `{!! route('ajax.proyekperumahan.index') !!}`;
            var table = $('#perumahanTable').DataTable({
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
                    data: 'alamat',
                    name: 'alamat'
                }, {
                    data: 'status',
                    name: 'status'
                }, {
                    data: 'action',
                    name: 'action'
                }],
            });
            {{-- ----------------------------- Datatables ----------------------------- --}}

            {{-- --------------------------- Tambah Function -------------------------- --}}
            $('#tambahPerumahan').click(function() {
                // console.log('tambah kriteria:');
                $('#formTambahPerumahan').trigger('reset');
            });

            $('#formTambahPerumahan').submit(function(e) {
                e.preventDefault();
                console.log('form submit');

                // var formData = $(this).serialize();
                var formData = new FormData($('#formTambahPerumahan')[0]);
                console.log('formData:', formData);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ route('ajax.proyekperumahan.store') }}`;

                $.ajax({
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    //     'enctype': "multipart/form-data"
                    // },
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    timeout: 5000,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#perumahanTable').block();
                        $('#tambahModal').block();
                    },
                }).done(function(data, textStatus, jqXHR) {
                    // Process data, as received in data parameter

                    // Send warning log message if response took longer than 2 seconds
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
                            icon: "danger",
                            timer: 1000,
                            showConfirmButton: false
                        });
                    });
                }).always(function(jqXHR, textStatus, errorThrown) {
                    // Hide spinner or loader
                    if (textStatus == 'success') {
                        $('#formTambahPerumahan').trigger('reset');
                        $('#tambahModal').unblock();
                        $('#tambahModal').modal('hide');
                        table.draw();
                        $('#perumahanTable').unblock();
                    }
                });
            });
            {{-- --------------------------- Tambah Function -------------------------- --}}

            {{-- --------------------------- Update Function -------------------------- --}}
            $(document).on('click', '.edit', function() {
                console.log('edit perumahan:');
                $('#editModal').modal('show');

                let data = $(this).data('single_source');
                console.log(data, data.image.path + data.image.name);

                $('#editTitle').html(data.nama);
                $('#imagePerumahanViewEdit').attr('src', `{{ asset('/') }}` + data.image.path + data
                    .image.name);
                $('#inputEditPerumahanId').val(data.id);
                $('#inputEditName').val(data.nama);
                $('#inputEditAlamat').val(data.alamat);
                $('#inputEditKeterangan').val(data.keterangan);
            });

            $(document).on('submit', '#formEditPerumahan', function(e) {
                e.preventDefault();
                console.log('form update');
                var id = $('#inputEditPerumahanId').val();
                var formData = new FormData($('#formEditPerumahan')[0]);
                // formData.append('_token', '{{ csrf_token() }}');
                formData.append('_method', 'PUT');
                console.log('formData:', formData);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ url('ajax.proyekperumahan/update') }}/` + id;
                // url.replaceAll('{idKriteria}', id);
                console.log(url);

                $.ajax({
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    //     'enctype': "multipart/form-data"
                    // },
                    type: 'POST',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    timeout: 5000,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#perumahanTable').block();
                        $('#formEditPerumahan').block();
                    },
                }).done(function(data, textStatus, jqXHR) {
                    // Process data, as received in data parameter

                    // Send warning log message if response took longer than 2 seconds
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
                            icon: "danger",
                            timer: 1000,
                            showConfirmButton: false
                        });
                    });
                }).always(function(jqXHR, textStatus, errorThrown) {
                    // Hide spinner or loader
                    if (textStatus == 'success') {
                        $('#formEditPerumahan').trigger('reset');
                        $('#editModal').modal('hide');
                        table.draw();
                        $('#perumahanTable').unblock();
                        $('#formEditPerumahan').unblock();
                    }
                });
            });
            {{-- --------------------------- Update Function -------------------------- --}}
        });
    </script>
@endpush
