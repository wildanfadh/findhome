<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Preferensi;

class KuesionerController extends Controller
{
    public function index()
    {
        return $this->generate_kuesioner();
    }

    public function hitung_bobot_kuesioner(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $kriteriaPreferensi = new Preferensi;
            $data_request_bobot = [];
            foreach ($data as $key => $value) {
                $new_key = str_replace('input_nilai_', '', $key);
                $data_request_bobot[$new_key] = $value;
            }
            $result_bobot = $this->hitung_bobot($data_request_bobot);
            // dd(($result_bobot));

            // delete old preferencys
            if (isset(auth()->user()->preferencys)) {
                foreach (auth()->user()->preferencys as $key => $value) {
                    $value->delete();
                }
            }

            if ($result_bobot['konsisten']) {
                $data_request = [];
                foreach ($result_bobot['bobot'] as $key => $value) {
                    array_push($data_request, ['user_id' => auth()->user()->id, 'kriteria_kode' => $key, 'bobot' => $value, 'created_at' => now()]);
                }
                $kriteriaPreferensi->insert($data_request);
            } else {
                return $this->conditionalResponse((object) [
                    'success' => false,
                    'message' => 'Data Tidak Konsisten! silahkan ulangi respon kuesioner',
                    'data' => null
                ]);
            }
            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil ditambahkan',
                'data' => null
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
