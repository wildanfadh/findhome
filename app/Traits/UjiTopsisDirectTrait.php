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

        /* ---------------------------- NILAI ALTERNATIF ---------------------------- */
        // get all data matrik keputusan
        $matrix = [];
        $perumahans = Perumahan::with(['kriteriaPerumahan' => fn ($kriper) => $kriper->with(['kriteria', 'subkriteria'])])->get();
        $kriterias = Kriteria::with(['subKriterias'])->get();
        foreach ($perumahans as $key => $perum) {
            $kriteriasPerPerum = [];
            foreach ($kriterias as $keykri => $kri) {
                $nilaiSubKriteria = 0;
                foreach ($perum->kriteriaPerumahan as $keykriper => $kriper) {
                    if ($kri->id == $kriper->kriteria_id) {
                        $nilaiSubKriteria = $kriper->subkriteria->nilai;
                    }
                }
                $kriteriasPerPerum[$kri->kode] = $nilaiSubKriteria;
            }
            $matrix[$perum->kode] = $kriteriasPerPerum;
        }

        /* ------------------------------- NORMALISASI ------------------------------ */
        // Mengkuadratkan Matrik
        $matrix_kuadrat = [];
        foreach ($matrix as $mkey => $mat) {
            $nidrat = []; // nilai kuadrat
            $total = 0;
            foreach ($mat as $mtkey => $matval) {
                $nidrat[$mtkey] = $matval * $matval;
                $total = $total + ($matval * $matval);
            }
            $nidrat['total'] = $total;
            $matrix_kuadrat[$mkey] = $nidrat;
        }
        // dd($matrix_kuadrat);

        // Normalisasi
        $normalisasis = [];
        foreach ($matrix_kuadrat as $nkey => $matku) {
            // dd($matku);
            $sqrt_total = round(sqrt($matku['total']));
            $matkus = [];
            foreach ($matku as $nkkey => $nkval) {
                // dd($nkval);
                if ($nkkey != 'total') {
                    $matkus[$nkkey] = round(sqrt($nkval)) / $sqrt_total;
                }
            }
            // dd($matkus);
            $normalisasis[$nkey] = $matkus;
        }
        // dd($matkuisasis);

        /* -------------------------- NORMALISASI TERBOBOT -------------------------- */
        // Normalisasi Terbobot
        $normalisasis_terbobot = [];
        foreach ($normalisasis as $ntkey => $normal) {
            // dd($normal, $ntkey);
            $terbobots = [];
            foreach ($normal as $ntkkey => $ntkval) {
                $kri = Kriteria::where('kode', $ntkkey)->first();
                $terbobots[$ntkkey] = $ntkval * $kri->bobot;
            }
            $normalisasis_terbobot[$ntkey] = $terbobots;
        }
        // dd($normalisasis_terbobot);

        /* -------------------------- MATRIKS SOLUSI IDEAL -------------------------- */
        // Matrik Solusi Ideal
        $matrik_solusi_ideal = [];
        foreach ($normalisasis_terbobot as $msikey => $normal) {
            $msival = [];
            foreach ($normal as $msivalkey => $msivalval) {
                $msival[$msivalkey] = $msivalval;
            }
            $matrik_solusi_ideal[$msikey] = $msival;
        }
        dd($matrik_solusi_ideal);

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
