<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait AjaxResponserTrait
{

    private function __construct()
    {
        $this->bobot = $bobot = [];
        $this->sifat = $sifat = [];
    }

    /**
     * Mengkuadratkan Matrik
     *
     * kuadratkan semua kriteria pada setiap alternatif
     *
     * @param   integer     @matrik
     */
    public function kuadratkanMatrik($matrik)
    {
    }

    /**
     * Normalisasi
     *
     * semua kriteria pada setiap alternatif
     *
     * @param   integer     @kriteriaAlternatif1
     * @param   integer     @kriteriaAlternatif2
     */
    public function normalisasi($kriteriaAlternatif1, $kriteriaAlternatif2)
    {
    }

    /**
     * Normalisasi Terbobot
     *
     * hitung semua kriteria pada setiap alternatif
     *
     * @param   integer     @kriteriaAlternatif1
     * @param   integer     @kriteriaAlternatif2
     */
    public function normalisasiTerbobot($kriteriaAlternatif1, $kriteriaAlternatif2)
    {
    }

    public function matrikSolusiIdeal()
    {
    }

    public function aPLus()
    {
    }

    public function aMin()
    {
    }

    public function jarakMatrikSolusiIdeal()
    {
    }

    public function nilaiPreferensi()
    {
    }

    public function Rangking()
    {
    }
}
