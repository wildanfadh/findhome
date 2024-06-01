<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
            $data_request = [];
            foreach ($data as $key => $value) {
                $new_key = str_replace('input_nilai_', '', $key);
                $data_request[$new_key] = $value;
            }
            $this->hitung_bobot($data_request);
            dd(($data));
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
