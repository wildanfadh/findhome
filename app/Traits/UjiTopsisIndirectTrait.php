<?php

namespace App\Traits;

use App\Models\Kriteria;
use App\Models\Perumahan;
use App\Enums\SifatKriteria;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

trait UjiTopsisIndirectTrait
{

    /**
     * Mengkuadratkan Matrik
     *
     * kuadratkan semua kriteria pada setiap alternatif
     *
     * @param   integer     @matrik
     */
    public function matrikKeputusan()
    {
        $matrix = [];
        $perumahans = Perumahan::with(['kriteriaPerumahan' => fn ($kriper) => $kriper->with(['kriteria', 'subkriteria'])])->where('is_verified', 1)->get();
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

        return $matrix;
    }

    /**
     * Mengkuadratkan Matrik
     *
     * kuadratkan semua kriteria pada setiap alternatif
     *
     * @param   integer     @matrik
     */
    public function kuadratkanMatrik($matrix)
    {
        $matrix_kuadrat = [];
        foreach ($matrix as $mkey => $mat) {
            $nidrat = []; // nilai kuadrat
            // $total = 0;
            foreach ($mat as $mtkey => $matval) {
                $nidrat[$mtkey] = $matval * $matval;
                // $total = $total + ($matval * $matval);
            }
            // $nidrat['total'] = $total;
            $matrix_kuadrat[$mkey] = $nidrat;
        }

        return $matrix_kuadrat;
    }

    /**
     * Normalisasi
     *
     * semua kriteria pada setiap alternatif
     *
     * @param   integer     @kriteriaAlternatif1
     * @param   integer     @kriteriaAlternatif2
     */
    public function normalisasi($matrix, $matrix_kuadrat)
    {
        // dd($matrix_kuadrat);
        $normalisasis = [];
        $totalAltKri = [];
        foreach ($matrix_kuadrat as $nkey => $matku) {
            foreach ($matku as $nkkey => $nkval) {
                $totalAltKri[$nkkey] = 0;
            }
        }
        foreach ($matrix_kuadrat as $nkey => $matku) {
            foreach ($matku as $nkkey => $nkval) {
                $totalAltKri[$nkkey] = $totalAltKri[$nkkey] + $nkval;
            }
        }

        foreach ($matrix as $nkey => $matku) {
            // dd($matku);
            $matkus = [];
            foreach ($matku as $nkkey => $nkval) {
                // dd($totalAltKri[$nkkey]);
                // $sqrt_total = round(sqrt($totalAltKri[$nkkey]));
                $sqrt_total = sqrt($totalAltKri[$nkkey]);
                // dd($sqrt_total);
                // $matkus[$nkkey] = round(sqrt($nkval)) / $sqrt_total;
                $matkus[$nkkey] = $nkval / $sqrt_total;
            }
            // dd($matkus);
            $normalisasis[$nkey] = $matkus;
        }
        // dd($totalAltKri);
        // dd($normalisasis);

        return $normalisasis;
    }

    /**
     * Normalisasi Terbobot
     *
     * hitung semua kriteria pada setiap alternatif
     *
     * @param   integer     @kriteriaAlternatif1
     * @param   integer     @kriteriaAlternatif2
     */
    public function normalisasiTerbobot($normalisasis)
    {
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
        return $normalisasis_terbobot;
    }

    public function matrikSolusiIdeal($normalisasis_terbobot)
    {
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

        return $matrik_solusi_ideal;
    }

    public function aPLus($normalisasis_terbobot, $matrik_solusi_ideal)
    {
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

        return $aplus;
    }

    public function aMin($normalisasis_terbobot, $matrik_solusi_ideal)
    {
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

        return $amin;
    }

    public function jarakMatrikSolusiIdeal($normalisasis_terbobot, $aplus, $amin)
    {
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

        return $jarak_solusi_ideal;
    }

    public function nilaiPreferensi($jarak_solusi_ideal)
    {
        $preferensi = [];
        foreach ($jarak_solusi_ideal as $tkey => $jarak) {
            $preferensi[$tkey] = $jarak['negatif'] / ($jarak['positif'] + $jarak['negatif']);
        }
        arsort($preferensi);

        return $preferensi;
    }

    public function Rangking()
    {
    }
}
