<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait UjiTopsisDirectTrait
{
    // bobot menyesuaikan request berdasarkan preference jika tidak akan default ambil dari bobot dasar database
    // tetap menyesuaikan dengan database
    private function __construct()
    {
        $this->bobot = $bobot = [];
        $this->sifat = $sifat = [];
    }

    /**
     * General Topsis
     *
     * Perhitungan Uji TOPSIS Secara Umum
     *
     * @param   array     @matrik
     */
    public function general($matrik)
    {

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
