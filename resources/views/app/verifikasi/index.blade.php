@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Daftar Verifikasi</h5>
            {{-- <p class="mb-0">This is a sample page</p> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Verifikasi Pendaftaran Pengembang</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-secondary" role="alert">
                        Pengembang 01
                    </div>
                    <div class="alert alert-secondary" role="alert">
                        Pengembang 03
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Verifikasi Data Perumahan</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-secondary" role="alert">
                        Perumahan 01
                    </div>
                    <div class="alert alert-secondary" role="alert">
                        Perumahan 03
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
