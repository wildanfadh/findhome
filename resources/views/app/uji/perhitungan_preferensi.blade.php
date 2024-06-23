@extends('layouts.app')

@push('styles')
    <style>
        .matriks {
            width: 400px;
            margin: 30px auto;
        }

        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin: 10px 0;
        }

        th {
            height: 40px;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">
                Perhitungan Uji Topsis
            </h5>
            {{-- <p class="mb-0">This is a sample page</p> --}}
            <button onclick="history.back()" class="btn btn-primary"><i class="ti ti-arrow-back-up"></i>
                Kembali</button>
            <div class="card-body">

                <div class="matriks matriks-keputusan">
                    <h5 class="text-center">Matrik Keputusan</h5>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                @foreach ($kriterias as $key => $item)
                                    <th>{{ "($item->kode) $item->nama" }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($matriks as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($item as $key2 => $item2)
                                        <td>{{ $item2 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="matriks matriks-keputusan-ternormalisasi">
                    <h5 class="text-center">Matrik Keputusan Ternormalisasi</h5>
                    <span>Mangkuadratkan Matriks</span>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                @foreach ($kriterias as $key => $item)
                                    <th>{{ "($item->kode) $item->nama" }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($matriks_kuadrat as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($item as $key2 => $item2)
                                        @php
                                            if ($key2 == 'total') {
                                                continue;
                                            }
                                        @endphp
                                        <td>{{ $item2 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span>Normalisasi</span>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                @foreach ($kriterias as $key => $item)
                                    <th>{{ "($item->kode) $item->nama" }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($matriks_normalisasi as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($item as $key2 => $item2)
                                        @php
                                            if ($key2 == 'total') {
                                                continue;
                                            }
                                        @endphp
                                        <td>{{ $item2 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="matriks matriks-normalisasi-terbobot">
                    <h5 class="text-center">Matrik Normalisasi Terbobot</h5>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                @foreach ($kriterias as $key => $item)
                                    <th>{{ "($item->kode) $item->nama" }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($normalisasi_bobot as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($item as $key2 => $item2)
                                        <td>{{ $item2 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="matriks matriks-solusi-ideal">
                    <h5 class="text-center">Matrik Solusi Ideal</h5>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                @foreach ($kriterias as $key => $item)
                                    <th>{{ "($item->kode) $item->nama" }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($solusi_ideal as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($item as $key2 => $item2)
                                        <td>{{ $item2 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="matriks matriks-solusi-ideal-positif">
                    <h5 class="text-center">Matrik Solusi Ideal Positif</h5>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                @foreach ($kriterias as $key => $item)
                                    <th>{{ "($item->kode) $item->nama" }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($solusi_ideal_positif as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($item as $key2 => $item2)
                                        <td>{{ $item2 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="matriks matriks-solusi-ideal-negatif">
                    <h5 class="text-center">Matrik Solusi Ideal Negatif</h5>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                @foreach ($kriterias as $key => $item)
                                    <th>{{ "($item->kode) $item->nama" }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($solusi_ideal_negatif as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($item as $key2 => $item2)
                                        <td>{{ $item2 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="matriks jarak-matriks-solusi-ideal">
                    <h5 class="text-center">Jarak Matrik Solusi Ideal</h5>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                <th>Positif</th>
                                <th>Negatif</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($jarak as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    @foreach ($item as $key2 => $item2)
                                        <td>{{ $item2 }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="matriks nilai-preferensi">
                    <h5 class="text-center">Nilai Preferensi</h5>
                    <table>
                        <thead class="text-center">
                            <tr>
                                <th>X</th>
                                <th>Nilai</th>
                                <th>Rangking</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($preferensi as $key => $item)
                                <tr>
                                    <td>{{ $key }}</td>
                                    <td>{{ $item }}</td>
                                    <td>{{ $loop->iteration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
@endsection
