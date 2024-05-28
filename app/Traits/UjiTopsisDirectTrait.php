<?php

namespace App\Traits;

use App\Models\Kriteria;
use App\Models\Perumahan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait UjiTopsisDirectTrait
{
    // bobot menyesuaikan request berdasarkan preference jika tidak akan default ambil dari bobot dasar database
    // tetap menyesuaikan dengan database
    // private function __construct()
    // {
    //     $this->bobot = $bobot = [];
    //     $this->sifat = $sifat = [];
    // }

    /**
     * General Topsis
     *
     * Perhitungan Uji TOPSIS Secara Umum
     *
     * @param   array     @matrik
     */
    public function uji_topsis_general()
    {
        // dd($matrik);
        // get all data
        $matrix = [];
        $perumahans = Perumahan::with(['kriteriaPerumahan' => fn ($kriper) => $kriper->with(['kriteria', 'subkriteria'])])->get();
        $kriterias = Kriteria::with(['subKriterias'])->get();
        // dd($perumahans, $kriterias);
        foreach ($perumahans as $key => $perum) {
            $kriteriasPerPerum = [];
            foreach ($perum->kriteriaPerumahan as $keykri => $kri) {
                // dd($kri->subkriteria);
                $kriteriasPerPerum['K' . $keykri + 1] = $kri->subkriteria->nilai;
            }
            // dd($kriteriasPerPerum);
            $matrix['A' . $key + 1] = $kriteriasPerPerum;
        }
        dd($matrix);

        // Mengkuadratkan Matrik

        // Normalisasi

        // Normalisasi Terbobot

        // Matrik Solusi Ideal

        // Aplus

        // Amin

        // Jarak Matrik Solusi Ideal

        // Nilai Preferensi pada setiap ALternatif

        // Perangkingan

    }

    /**
     * Preference Topsis
     *
     * Perhitungan Uji TOPSIS By Preference Calon Pembeli
     *
     * @param   array     @matrik
     */
    public function preference($matrik)
    {
        $matrik_kuadrat = [];
        // Mengkuadratkan Matrik

        // Normalisasi

        // Normalisasi Terbobot

        // Matrik Solusi Ideal

        // Aplus

        // Amin

        // Jarak Matrik Solusi Ideal

        // Nilai Preferensi pada setiap ALternatif

        // Perangkingan

    }
}
