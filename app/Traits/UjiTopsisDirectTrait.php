<?php

namespace App\Traits;

use App\Enums\SifatKriteria;
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
            $min = min($normal);
            $max = max($normal);
            $positif = [];
            $negatif = [];
            foreach ($normal as $msivalkey => $msivalval) {
                $kri = Kriteria::where('kode', $msivalkey)->first();
                if ($kri->sifat == SifatKriteria::BENEFIT) {
                    $positif[$msivalkey] = $max;
                    $negatif[$msivalkey] = $min;
                } else {
                    $positif[$msivalkey] = $min;
                    $negatif[$msivalkey] = $max;
                }
            }
            $matrik_solusi_ideal['positif'] = $positif;
            $matrik_solusi_ideal['negatif'] = $negatif;
        }
        // dd($matrik_solusi_ideal);

        /* ---------------------------------- TOTAL --------------------------------- */

        // Aplus
        $aplus = [];
        foreach ($normalisasis_terbobot as $tkey => $normal) {
            $plus = [];
            foreach ($normal as $tvalkey => $tvalval) {
                foreach ($matrik_solusi_ideal as $msikey => $msival) {
                    // $aplus[$tvalkey] = $tvalval;
                    if ($msikey == 'positif') {
                        $plus[$tvalkey] = ($tvalval - $msival[$tvalkey]) * ($tvalval - $msival[$tvalkey]);
                    }
                }
            }
            $aplus[$tkey] = $plus;
        }
        // dd($aplus);

        // Amin
        $amin = [];
        foreach ($normalisasis_terbobot as $tkey => $normal) {
            $min = [];
            foreach ($normal as $tvalkey => $tvalval) {
                foreach ($matrik_solusi_ideal as $msikey => $msival) {
                    if ($msikey == 'negatif') {
                        $min[$tvalkey] = ($tvalval - $msival[$tvalkey]) * ($tvalval - $msival[$tvalkey]);
                    }
                }
            }
            $amin[$tkey] = $min;
        }
        // dd($amin);

        // Jarak Matrik Solusi Ideal
        $jarak_solusi_ideal = [];
        foreach ($normalisasis_terbobot as $tkey => $normal) {
            $jarakplus = [];
            foreach ($aplus as $apkey => $apval) {
                if ($tkey == $apkey) {
                    $jarakplus = sqrt(array_sum($apval));
                }
            }
            $jarakmin = [];
            foreach ($amin as $amkey => $amval) {
                if ($tkey == $amkey) {
                    $jarakmin = sqrt(array_sum($amval));
                }
            }
            $jarak_solusi_ideal[$tkey] = ['positif' => $jarakplus, 'negatif' => $jarakmin];
        }
        // dd($jarak_solusi_ideal);

        // Nilai Preferensi pada setiap ALternatif
        $preferensi = [];
        foreach ($jarak_solusi_ideal as $tkey => $jarak) {
            $preferensi[$tkey] = $jarak['negatif'] / ($jarak['positif'] + $jarak['negatif']);
        }
        // dd($preferensi);

        // Perangkingan
        arsort($preferensi);
        $rank = $preferensi;

        // Return data Perumahan Rank
        $data = [];
        foreach ($rank as $key => $value) {
            $data[$key] = [
                'nilai' => $value,
                'data' => Perumahan::where('kode', $key)->first(),
            ];
        }
        return $data;
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
