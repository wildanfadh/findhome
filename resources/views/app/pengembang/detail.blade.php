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
                        <button class="btn btn-success float-end verif-perumahan"><i class="ti ti-check"></i>
                            Verif Perumahan</button>
                    @endhasanyrole
                </div>
            </div>
        </div>
    </div>
@endsection
