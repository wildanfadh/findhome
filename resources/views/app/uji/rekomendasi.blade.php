@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h5 class="card-title fw-semibold mb-4">Hasil Uji Rekomendasi</h5>
                    <p class="mb-0">Hasil Rekomendasi Secara Umum</p>
                </div>
                <div class="col-6">
                    @hasanyrole('Umum')
                        {{-- <button class="btn btn-warning float-end" data-bs-toggle="modal" data-bs-target="#preferensiModal">Atur
                            Preferensi</button> --}}
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle float-end" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Atur Preferensi
                            </button>
                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" href="#" data-bs-toggle="modal"
                                        data-bs-target="#kuesionerModal" id="btn_kuesioner">Kueisoner</button></li>
                                <li><a class="dropdown-item" href="#">Manual</a></li>
                            </ul>
                        </div>
                    @endhasanyrole
                </div>
            </div>

        </div>
        <div class="card-body">
            @php
                $no = 1;
            @endphp
            @foreach ($hasilUji as $key => $item)
                @php
                    $alert_class = 'alert-secondary';
                    if (in_array($no, [1, 2, 3])) {
                        $alert_class = 'alert-success';
                    }
                @endphp
                <div class="alert {{ $alert_class }}" role="alert">
                    {{ $item['data']->nama }} <a href="{{ route('page.perumahan.detail', $item['data']->id) }}"
                        class="btn btn-sm btn-primary float-end">Detail</a>
                </div>
                @php
                    $no++;
                @endphp
            @endforeach
        </div>
    </div>

    <!-- Modal Kuesioner -->
    <div class="modal fade" id="kuesionerModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="kuesionerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="kuesionerModalLabel">Kuesioner Perbandingan Antar Kriteria Perumahan
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="box-description">
                        <p>
                            Pada kuesioner ini terdapat {{ $kriterias->count() }} kriteria yang dijadikan bahan pertimbangan
                            dalam memilih rumah siap
                            huni. Kriteria tersebut antara lain sebagai berikut:
                            </br>
                            </br>
                            Keterangan:
                        </p>
                        <table class="table">
                            @foreach ($kriterias as $item)
                                <tr>
                                    <th>{{ $item->kode }}</th>
                                    <td> {{ $item->keterangan }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <p>Anda diminta menjawab soal perbandingan antar kriteria berikut.</p>
                    </div>

                    <hr class="solid" style=" border-top: 3px solid #bbb;">

                    <div class="box-questions">
                        <form id="form_kuesioner">
                            @php
                                $noPertanyaan = 1;
                            @endphp
                            @foreach ($kuesioners as $key => $item)
                                <p>{{ $item['pertanyaan'] }}</p>
                                <input type="hidden" name="input_nilai_{{ $item['kode'] }}" id="input_nilai">
                                @foreach ($item['pilihans'] as $pkey => $pil)
                                    <div class="form-check my-3">
                                        <input class="form-check-input" type="radio" {{-- name="pertanyaan_{{ $key }}" --}}
                                            id="pertanyaan_{{ $key . '_' . $pkey }}" data-nilai="{{ $pkey }}"
                                            data-inputname="input_nilai_{{ $item['kode'] }}" @required(true)>
                                        <label class="form-check-label" for="pertanyaan_{{ $key . '_' . $pkey }}">
                                            {{ $pil }}
                                        </label>
                                    </div>
                                @endforeach
                                @php
                                    $noPertanyaan++;
                                @endphp
                            @endforeach

                            <button type="submit" class="btn btn-sm btn-danger d-none"
                                id="btn_submit_kuesioner">Submit</button>
                            <button type="reset" class="btn btn-sm btn-danger">Reset</button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="btn_simpan_kuesioner">Simpan</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            {{-- ---------------------------- ADD FUNCTION ---------------------------- --}}
            $('#btn_kuesioner').on('click', function() {
                $('#form_kuesioner').trigger('reset');
            });

            $(document).on('change', 'input[type="radio"]', function() {
                var nilai = $(this).attr('data-nilai');
                var inputName = $(this).attr('data-inputname');
                console.log('nilai:', nilai);
                console.log('inputname:', inputName);
                // console.log($(`input[name="${inputName}"]`));
                $(`input[name="${inputName}"]`).val(nilai);
            });

            $('#btn_simpan_kuesioner').on('click', function() {
                console.log('add function');
                $('#btn_submit_kuesioner').trigger('click');
                // let formData = $('#form_kuesioner').serialize();
                // console.log(formData);
            });

            $('#form_kuesioner').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                // console.log(formData);

                // required for ajax request
                var msBeforeAjaxCall = new Date().getTime();

                var url = `{{ route('ajax.kuesioner.hitung_bobot_kuesioner') }}`;

                $.ajax({
                    type: 'GET',
                    url: url,
                    data: formData,
                    dataType: 'json',
                    timeout: 5000,
                    beforeSend: function() {
                        // show spinner or loader
                        $('#form_kuesioner').block();
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
                    if (textStatus == 'success') {
                        $('#form_kuesioner').unblock();
                        $('#kuesionerModal').modal('hide');
                    }
                });
            })
            {{-- ---------------------------- ADD FUNCTION ---------------------------- --}}
        });
    </script>
@endpush
