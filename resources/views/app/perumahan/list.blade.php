@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">List Perumahan</h5>
            {{-- <p class="mb-0">This is a sample page</p> --}}
        </div>
    </div>

    <div class="row">
        @foreach ($perumahan as $item)
            <div class="col-3">
                <div class="card" style="height: 500px;">
                    @if ($item->images != null)
                        <img src="{{ asset($item->images[0]->path . $item->images[0]->name) }}"
                            class="object-fit-contain border rounded" style="height: 250px" alt="...">
                    @else
                        <img src="https://placehold.co/600x400" class="object-fit-contain border rounded"
                            style="height: 250px" alt="...">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nama }}</h5>
                        <h6 class="card-text">{{ $item->pengembang->nama_perusahaan }}.</h6>
                        <p class="card-text">{{ $item->alamat }}.</p>
                        <a href="{{ route('page.perumahan.detail', $item->id) }}" class="btn btn-primary">Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
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
