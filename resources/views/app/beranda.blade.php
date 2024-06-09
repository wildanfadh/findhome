@extends('layouts.app')

@section('content')
    {{-- <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Sample Page</h5>
            <p class="mb-0">This is a sample page </p>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Rekomendasi Tertinggi</h5>
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
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Perumahan Terkini</h5>
                </div>
                <div class="card-body">
                    @foreach ($perumahan_terkini as $item)
                        <div class="alert alert-secondary" role="alert">
                            {{ $item->nama }} <a href="{{ route('page.perumahan.detail', $item->id) }}"
                                class="btn btn-sm btn-info float-end"> <i class="ti ti-id"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
