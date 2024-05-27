@extends('layouts.app')

@section('content')
    <div class="card">
        {{-- <img src="{{ asset('assets/images/products/s4.jpg') }}" height="300" class="card-img-top" alt="..."> --}}
        @if ($data->image != null)
            <img src="{{ asset($data->image->path . $data->image->name) }}" class="object-fit-contain border rounded"
                style="max-height: 500px" alt="...">
        @else
            <img src="https://placehold.co/600x400" class="object-fit-contain border rounded" style="max-height: 500px"
                alt="...">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{ $data->nama }}</h5>
            <p class="card-text">{{ $data->alamat }}</p>
            <p class="card-text">{{ $data->pengembang->nama_perusahaan }}</p>
            <p class="card-text">{{ $data->keterangan }}</p>
            {{-- <p class="card-text">Asosiasi</p> --}}
        </div>
        <div class="card-footer">
            <button onclick="history.back()" class="btn btn-primary"><i class="ti ti-arrow-back-up"></i>
                Kembali</button>
            {{-- <a href="{{ route('page.verifikasi.index') }}" class="btn btn-primary"><i class="ti ti-arrow-back-up"></i>
                Kembali</a> --}}
            @hasanyrole('Admin')
                <button class="btn btn-success float-end verif-perumahan"><i class="ti ti-check"></i>
                    Verif Perumahan</button>
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
                                            <button type="button" class="btn btn-info btn-simpan-subkriteria"
                                                id="save_kriteria_perumahan" data-kriteria="{{ $item }}"
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
                    }
                });
            });
            {{-- ----------------------- Save Kriteria Perumahan ---------------------- --}}

            {{-- --------------------------- Verif Perumahan -------------------------- --}}
            $('.verif-perumahan').on('click', function() {
                console.log('verif perumahan');
            })
            {{-- --------------------------- Verif Perumahan -------------------------- --}}
        });
    </script>
@endpush
