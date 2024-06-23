@extends('layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endpush

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
                        <thead class="text-center">
                            <tr class="text-center">
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
                            <label for="inputHarga" class="form-label">Harga Rumah Subsidi tersedia<span
                                    class="required-symbol">*</span></label>
                            <input type="text" name="harga" class="form-control" id="inputHarga"
                                aria-describedby="hargaHelp" pattern="^\$\d{1.3}(.\d{3})*(\,\d+)?$" value=""
                                data-type="currency" @required(true)>
                        </div>

                        <div class="mb-3">
                            <label for="inputAlamat" class="form-label">Alamat<span class="required-symbol">*</span></label>
                            <textarea name="alamat" class="form-control" id="inputAlamat" rows="3" @required(true)></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="inputLokasi" class="form-label">Titik Lokasi</label>
                            <div class="input-group">
                                <input type="text" name="latitude" aria-label="Latitude" class="form-control"
                                    placeholder="Latitude">
                                <input type="text" name="longitude" aria-label="Longitude" class="form-control"
                                    placeholder="Longitude">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="inputKeterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="inputKeterangan"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="inputGambar" class="form-label">Gambar<span class="required-symbol">*</span></label>
                            <input name="gambar[]" type="file" class="form-control" id="inputGambar" accept="image/*"
                                multiple @required(true)>
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
                    {{-- <img src="https://placehold.co/600x400" alt="image_perumahan" class="object-fit-contain border rounded"
                        id="imagePerumahanViewEdit" style="width: 100%; max-height: 300px;"> --}}
                    <form id="formEditPerumahan" enctype="multipart/form-data">
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
                            <label for="inputEditHarga" class="form-label">Harga Rumah Subsidi tersedia<span
                                    class="required-symbol">*</span></label>
                            <input type="text" name="harga" class="form-control" id="inputEditHarga"
                                aria-describedby="hargaHelp" pattern="^\$\d{1.3}(.\d{3})*(\,\d+)?$" value=""
                                data-type="currency" @required(true)>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditAlamat" class="form-label">Alamat<span
                                    class="required-symbol">*</span></label>
                            <textarea name="alamat" class="form-control" id="inputEditAlamat" rows="3" @required(true)></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditLokasi" class="form-label">Titik Lokasi</label>
                            <div class="input-group">
                                <input type="text" name="latitude" aria-label="Latitude" class="form-control"
                                    placeholder="Latitude" id="inputEditLat">
                                <input type="text" name="longitude" aria-label="Longitude" class="form-control"
                                    placeholder="Longitude" id="inputEditLang">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditKeterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="inputEditKeterangan"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="inputEditGambar" class="form-label">Gambar</label>
                            <input name="gambar[]" type="file" class="form-control" id="inputEditGambar" multiple
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
    <!-- include summernote css/js -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {

            {{-- ----------------------------- Datatables ----------------------------- --}}
            var url = `{!! route('ajax.proyekperumahan.perumahan_by_pengembang') !!}`;
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
                    name: 'action',
                    width: '15%'
                }],
            });
            {{-- ----------------------------- Datatables ----------------------------- --}}

            // ========== Summernote ==========
            $('#inputKeterangan').summernote({
                placeholder: 'Keterangan',
                tabsize: 2,
                height: 100,
                toolbar: [
                    // ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    // ['color', ['color']],
                    ['para', ['ol']]
                ]
            });
            $('#inputEditKeterangan').summernote({
                placeholder: 'Keterangan',
                tabsize: 2,
                height: 100,
                toolbar: [
                    // ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    // ['color', ['color']],
                    ['para', ['ol']],
                ]
            });
            // ========== Summernote ==========


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
                    if (jqXHR.responseJSON
                        .errors) {
                        var errors = objectToArray(jqXHR.responseJSON
                            .errors);

                        return errors.forEach(element => {
                            Swal.fire({
                                toast: true,
                                title: "Gagal!",
                                text: element[1][0],
                                icon: "warning",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            title: "Gagal!",
                            text: jqXHR.responseJSON.message,
                            icon: "warning",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }).always(function(jqXHR, textStatus, errorThrown) {
                    // Hide spinner or loader
                    $('#perumahanTable').unblock();
                    $('#tambahModal').unblock();
                    if (textStatus == 'success') {
                        $('#formTambahPerumahan').trigger('reset');
                        $('#tambahModal').modal('hide');
                        table.draw();
                    }
                });
            });
            {{-- --------------------------- Tambah Function -------------------------- --}}

            {{-- --------------------------- Update Function -------------------------- --}}
            $(document).on('click', '.edit', function() {
                console.log('edit perumahan:');
                $('#editModal').modal('show');

                let data = $(this).data('single_source');
                console.log(data);
                // console.log(data, data.image.path + data.image.name);

                $('#editTitle').html(data.nama);
                // if (data.image) {
                //     $('#imagePerumahanViewEdit').attr('src', `{{ asset('/') }}` + data.image.path + data
                //         .image.name);
                // }
                $('#inputEditPerumahanId').val(data.id);
                $('#inputEditName').val(data.nama);
                $('#inputEditHarga').val(data.harga);
                $('#inputEditAlamat').val(data.alamat);
                if (data.lat_lang) {
                    var latlang = data.lat_lang.split(',');
                    $('#inputEditLat').val(latlang[0]);
                    $('#inputEditLang').val(latlang[1]);
                }
                $('#inputEditKeterangan').summernote('code', data.keterangan);
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
                    if (jqXHR.responseJSON
                        .errors) {
                        var errors = objectToArray(jqXHR.responseJSON
                            .errors);

                        return errors.forEach(element => {
                            Swal.fire({
                                toast: true,
                                title: "Gagal!",
                                text: element[1][0],
                                icon: "warning",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            title: "Gagal!",
                            text: jqXHR.responseJSON.message,
                            icon: "warning",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                }).always(function(jqXHR, textStatus, errorThrown) {
                    // Hide spinner or loader
                    $('#perumahanTable').unblock();
                    $('#formEditPerumahan').unblock();
                    if (textStatus == 'success') {
                        $('#formEditPerumahan').trigger('reset');
                        $('#editModal').modal('hide');
                        table.draw();
                    }
                });
            });
            {{-- --------------------------- Update Function -------------------------- --}}

            {{-- --------------------------- Delete Function -------------------------- --}}
            $(document).on('click', '.delete', function() {
                console.log('delete perumahan:');
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
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {

                        // required for ajax request
                        var msBeforeAjaxCall = new Date().getTime();

                        $.ajax({
                            type: 'POST',
                            url: `{{ url('ajax.proyekperumahan/delete') }}/${data.id}`,
                            data: {
                                '_token': '{{ csrf_token() }}',
                                '_method': 'DELETE',
                                'id': data.id
                            },
                            dataType: 'json',
                            timeout: 5000,
                            beforeSend: function() {
                                // show spinner or loader
                                $('#perumahanTable').block();
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
                            if (jqXHR.responseJSON
                                .errors) {
                                var errors = objectToArray(jqXHR.responseJSON
                                    .errors);

                                return errors.forEach(element => {
                                    Swal.fire({
                                        toast: true,
                                        title: "Gagal!",
                                        text: element[1][0],
                                        icon: "warning",
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                });
                            } else {
                                Swal.fire({
                                    toast: true,
                                    title: "Gagal!",
                                    text: jqXHR.responseJSON.message,
                                    icon: "warning",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        }).always(function(jqXHR, textStatus, errorThrown) {
                            // Hide spinner or loader
                            $('#perumahanTable').unblock();
                            if (textStatus == 'success') {
                                table.draw();
                            }
                        });
                    }
                });
            });
            {{-- --------------------------- Delete Function -------------------------- --}}
        });
    </script>
@endpush
