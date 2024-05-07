@extends('layouts.app')

@section('content')
    <div class="card">
        <img src="{{ asset('assets/images/products/s4.jpg') }}" height="300" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Nama Perumahan</h5>
            <p class="card-text">Alamat Perumahan</p>
            <p class="card-text">Pengembang</p>
            <p class="card-text">Asosiasi</p>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h5>Peta Lokasi</h5>
                </div>
                <div class="card-body">
                    <div class="map"></div>

                    <div class="info">
                        Kantor Pemasaran
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <h5>Detail Rumah</h5>
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h5 class="card-title">Detail Rumah</h5>
                            <p class="card-text">Alamat Perumahan</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    Denah Rumah
                </div>
                <div class="col-4">
                    Harga dan Fasilitas
                </div>

                <div class="col-12">
                    Spesifikasi Teknis
                </div>
            </div>
        </div>
    </div>
@endsection
