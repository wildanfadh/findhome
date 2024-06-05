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
                    @foreach ($pengembang as $item)
                        <div class="alert alert-secondary" role="alert">
                            {{-- {{ $item->nama_perusahaan . ' (' . $item->akun->name . ')' }} --}}
                            {{ $item->nama_perusahaan }}
                            <a href="{{ route('page.pengembang.detail', $item->id) }}"
                                class="btn btn-sm btn-info float-end"> <i class="ti ti-id"></i>
                            </a>
                        </div>
                    @endforeach
                    {{-- <div class="accordion" id="accordionPengembang">

                        @foreach ($pengembang as $key => $item)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $key }}" aria-expanded="false"
                                        aria-controls="collapse{{ $key }}">
                                        {{ $item->nama_perusahaan }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionPengembang">
                                    <div class="accordion-body">
                                        <table class="table">
                                            <tr>
                                                <th>Nama Direktur</th>
                                                <td>{{ $item->akun->name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Verifikasi Data Perumahan</h5>
                </div>
                <div class="card-body">
                    @foreach ($perumahan as $item)
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


@push('scripts')
    <script>
        $(document).ready(function() {
            {{-- --------------------------- reload on back --------------------------- --}}
            window.addEventListener("pageshow", function(event) {
                var historyTraversal = event.persisted ||
                    (typeof window.performance != "undefined" &&
                        window.performance.navigation.type === 2);
                if (historyTraversal) {
                    // Handle page restore.
                    window.location.reload();
                }
            });
            {{-- --------------------------- reload on back --------------------------- --}}
        });
    </script>
@endpush
