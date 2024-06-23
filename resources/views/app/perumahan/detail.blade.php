@extends('layouts.app')

@push('styles')
    <style>
        .maps {
            height: 500px;
        }

        .maps iframe {
            /* height: 80%; */
            width: 100%;
            left: 0;
            top: 0;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        {{-- <img src="{{ asset('assets/images/products/s4.jpg') }}" height="300" class="card-img-top" alt="..."> --}}
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @if ($data->images != null || count($data->images) < 1)
                    @foreach ($data->images as $key => $image)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ asset($image->path . $image->name) }}"
                                class="d-block w-100 object-fit-contain border rounded" style="max-height: 500px">
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item">
                        <img src="https://placehold.co/600x400" class="d-block w-100 object-fit-contain border rounded"
                            style="max-height: 500px" alt="...">
                    </div>
                @endif

            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <h6 class="card-text">Nama Perumahan</h6>
                    <p class="card-text">{{ $data->nama }}</p>
                    <h6 class="card-text">Harga Rumah Subsidi tersedia</h6>
                    <p class="card-text">Rp {{ number_format($data->harga, 0, ',', '.') }}</p>
                    <h6 class="card-text">Alamat</h6>
                    <p class="card-text">{{ $data->alamat }}</p>
                    <h6 class="card-text">Pengembang</h6>
                    <p class="card-text">{{ $data->pengembang->nama_perusahaan }}</p>
                    <h6 class="card-text">Deskripsi</h6>
                    <p class="card-text">{!! $data->keterangan ?? '-' !!}</p>
                    {{-- <p class="card-text">Asosiasi</p> --}}
                </div>
                <div class="col-6">
                    <h6 class="card-text">Peta Lokasi</h6>
                    <div class="maps">
                        @php
                            $latitude = 0;
                            $longitude = 0;
                            if ($data->lat_lang) {
                                // get longitude & latitude from link string
                                $cordinates = explode(',', $data->lat_lang);

                                // get longitude & latitude from link string
                                $latitude = $cordinates[0];
                                $longitude = $cordinates[1];
                            }
                        @endphp

                        <iframe
                            src="https://maps.google.com/maps?q={{ $latitude . ',' . $longitude }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button onclick="history.back()" class="btn btn-primary"><i class="ti ti-arrow-back-up"></i>
                Kembali</button>
            {{-- <a href="{{ route('page.verifikasi.index') }}" class="btn btn-primary"><i class="ti ti-arrow-back-up"></i>
                Kembali</a> --}}
            @hasanyrole('Admin')
                @if ($data->is_verified == 0)
                    <button class="btn btn-success float-end verif-perumahan"><i class="ti ti-check"></i>
                        Verif Perumahan</button>
                @endif
            @endhasanyrole
        </div>
    </div>

    @hasanyrole('Admin')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">Daftar Kriteria dan Sub Kriteria</h5>
                            </div>
                            {{-- <div class="col-6">
                            <button class="btn btn-primary float-end" id="tambahSubKriteria" data-bs-toggle="modal"
                                data-bs-target="#tambahModal">Tambah</button>
                        </div> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="kriteriaTable" class="table">
                            <thead>
                                <tr class="text-start">
                                    <th>NO</th>
                                    <th>Kriteria</th>
                                    <th>Sub Kriteria</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kriteria as $key => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>
                                            <select name="sub_kriteria" class="form-control"
                                                id="sub_kriteria_select2_{{ $key }}" style="width: 100%">
                                                @foreach ($item->subKriterias as $sub)
                                                    <option value=""></option>
                                                    {{-- <option value="0" selected>Pilih ini</option> --}}
                                                    <option value="{{ $sub->id }}">
                                                        {{ $sub->uraian }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-simpan-subkriteria"
                                                id="save_kriteria_perumahan" data-kriteriaId="{{ $item->id }}"
                                                data-kriteria="{{ $item }}"
                                                data-idsubkriteria="sub_kriteria_select2_{{ $key }}"> <i
                                                    class="ti ti-device-floppy"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endhasanyrole
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let data_kriteria = {!! json_encode($kriteria) !!};
            let data_kriteria_perumahan = {!! json_encode($kriteriaPerumahan) !!};
            $.each(data_kriteria, function(indexInArray, valueOfElement) {
                // console.log(valueOfElement);
                // console.log('sub_kriteria_select2_' + indexInArray);
                $('#sub_kriteria_select2_' + indexInArray).select2({
                    theme: "bootstrap",
                    allowClear: true,
                    placeholder: 'Pilih ' + valueOfElement.nama
                });
                let sub_kriteria_selected = 0;
                $.each(valueOfElement.sub_kriterias, function(indexSub, valSub) {
                    // console.log(valSub, data_kriteria_perumahan);
                    $.each(data_kriteria_perumahan, function(indexKP, valKriPer) {
                        if (valKriPer.sub_kriteria_id == valSub.id) {
                            sub_kriteria_selected = valSub.id;
                        }
                    });
                });
                console.log(sub_kriteria_selected);
                $('#sub_kriteria_select2_' + indexInArray).val(sub_kriteria_selected).trigger(
                    'change');
                if (sub_kriteria_selected != 0) {
                    $('button[data-kriteriaId="' + valueOfElement.id + '"]').removeClass('btn-warning')
                        .addClass('btn-info');
                }
            });

            {{-- ----------------------- Save Kriteria Perumahan ---------------------- --}}
            $(document).on('click', '#save_kriteria_perumahan', function() {
                console.log('save kriteria perumahan');
                let kriteria = $(this).data('kriteria');
                let idsubkriteria = $(this).data('idsubkriteria');
                let sub_kriteria = $('#' + idsubkriteria).val();
                console.log('data kriteria:', kriteria, sub_kriteria);

                let formData = {
                    _token: '{{ csrf_token() }}',
                    perumahan_id: {!! $data->id !!},
                    kriteria_id: kriteria.id,
                    sub_kriteria_id: sub_kriteria
                };

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ route('ajax.proyekperumahan.request_kriteria_perumahan') }}`;

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
                        $('#kriteriaTable').unblock();
                        $('button[data-kriteriaId="' + kriteria.id + '"]').removeClass(
                                'btn-warning')
                            .addClass('btn-info');
                    }
                });
            });
            {{-- ----------------------- Save Kriteria Perumahan ---------------------- --}}

            {{-- --------------------------- Verif Perumahan -------------------------- --}}
            $('.verif-perumahan').on('click', function() {
                console.log('verif perumahan');

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Data pengembang akan diverifikasi',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Verif',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('verif pengembang');
                        let url =
                            "{{ route('ajax.verifikasi.verif_perumahan', ':id') }}"
                            .replace(':id', '{{ $data->id }}');

                        // required for ajax request
                        var msBeforeAjaxCall = new Date().getTime();

                        // var url = ``;

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: 'PUT',
                                id: '{{ $data->id }}'
                            },
                            dataType: 'json',
                            timeout: 5000,
                            beforeSend: function() {
                                // show spinner or loader

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
                            console.log(jqXHR.responseJSON, textStatus, errorThrown);
                            // Request failed. Show error message to user.
                            // errorThrown has error message, or 'timeout' in case of timeout.

                            if (jqXHR.responseJSON.errors == undefined) {
                                Swal.fire({
                                    toast: true,
                                    title: "Gagal!",
                                    text: jqXHR.responseJSON.message,
                                    icon: "warning",
                                    // timer: 1000,
                                    // showConfirmButton: false
                                });
                            } else {
                                var errors = objectToArray(jqXHR.responseJSON
                                    .errors);
                                console.log(errors);

                                return errors.forEach(element => {
                                    Swal.fire({
                                        toast: true,
                                        title: "Gagal!",
                                        text: element[1][0],
                                        icon: "warning",
                                        timer: 1000,
                                        showConfirmButton: false
                                    });
                                });
                            }
                        }).always(function(jqXHR, textStatus, errorThrown) {
                            // Hide spinner or loader
                            if (textStatus == "success") {
                                // reload page
                                window.location.reload();
                            }
                        });
                    }
                })
            })
            {{-- --------------------------- Verif Perumahan -------------------------- --}}
        });
    </script>
@endpush
