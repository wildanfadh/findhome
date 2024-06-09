@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- <h5 class="card-title fw-semibold mb-4">Pengembang ( <span>{{ $pengembang->nama_perusahaan }}</span> ) </h5> --}}
            {{-- <p class="mb-0">This is a sample page </p> --}}
            <table class="table">
                <tr>
                    <th>Nama Perusahaan</th>
                    <td>{{ $pengembang->nama_perusahaan }}</td>
                </tr>
                <tr>
                    <th>Nama Direktur/Petinggi</th>
                    <td>{{ $pengembang->akun->name }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $pengembang->akun->no_hp }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $pengembang->akun->email }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $pengembang->alamat }}</td>
                </tr>
            </table>
            <div class="row">
                <div class="col-6">
                    <button onclick="history.back()" class="btn btn-primary"><i class="ti ti-arrow-back-up"></i>
                        Kembali</button>
                </div>
                <div class="col-6">
                    @hasanyrole('Admin')
                        @if ($pengembang->is_verified == 0)
                            <button class="btn btn-success float-end verif-perumahan"><i class="ti ti-check"></i>
                                Verif Perumahan</button>
                        @endif
                    @endhasanyrole
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            {{-- ------------------------ Verif Data Pengembang ----------------------- --}}
            $(".verif-perumahan").click(function() {
                // console.log('verif pengembang');
                // verif with swal confirmation
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
                            "{{ route('ajax.verifikasi.verif_pengembang', ':id') }}"
                            .replace(':id', '{{ $pengembang->id }}');

                        // required for ajax request
                        var msBeforeAjaxCall = new Date().getTime();

                        // var url = ``;

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: 'PUT',
                                id: '{{ $pengembang->id }}'
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
                            if (textStatus == "success") {
                                // reload page
                                window.location.reload();
                            }
                        });
                    }
                })
            })
            {{-- ------------------------ Verif Data Pengembang ----------------------- --}}

        });
    </script>
@endpush
