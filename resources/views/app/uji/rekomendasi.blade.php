@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title fw-semibold mb-4">Hasil Uji Rekomendasi</h5>
            <p class="mb-0">Hasil Rekomendasi Secara Umum</p>
        </div>
        <div class="card-body">
            @foreach ($hasilUji as $key => $item)
                <div class="alert alert-secondary" role="alert">
                    {{ $item['data']->nama }} <a href="{{ route('page.perumahan.detail', $item['data']->id) }}"
                        class="btn btn-sm btn-primary float-end">Detail</a>
                </div>
            @endforeach
            {{-- <div class="alert alert-success" role="alert">
                A simple success alert—check it out!
            </div>
            <div class="alert alert-success" role="alert">
                A simple success alert—check it out!
            </div>
            <div class="alert alert-success" role="alert">
                A simple success alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div>
            <div class="alert alert-secondary" role="alert">
                A simple secondary alert—check it out!
            </div> --}}
        </div>
    </div>
@endsection
