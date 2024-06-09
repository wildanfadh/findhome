<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Perumahan;
use App\Models\Pengembang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Kriteria;

class VerifikasiController extends Controller
{
    // verif pengembang
    public function verifPengembang($id)
    {
        DB::beginTransaction();
        try {
            $pengembang = Pengembang::find($id);
            $pengembang->update([
                'is_verified' => 1,
            ]);

            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil diupdate',
                'data' => $pengembang
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->conditionalResponse((object) [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    // verif perumahan
    public function verifPerumahan($id)
    {
        DB::beginTransaction();
        try {
            $perumahan = Perumahan::find($id);

            // check if pengembang has verified
            if ($perumahan->pengembang->is_verified == 0) {
                return $this->conditionalResponse((object) [
                    'success' => false,
                    'message' => 'Pengembang Belum Terverifikasi',
                ]);
            } elseif ($perumahan->kriteriaPerumahan()->count() < Kriteria::count()) {
                return $this->conditionalResponse((object) [
                    'success' => false,
                    'message' => 'Lengkapi Kriteria Terlebih dahulu',
                ]);
            } else {
                $perumahan->update([
                    'is_verified' => 1,
                ]);
            }

            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil diupdate',
                'data' => $perumahan
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->conditionalResponse((object) [
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
