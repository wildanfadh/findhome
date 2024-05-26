<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KriteriaPerumahan extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data_request = [];
            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil ditambahkan',
                'data' => $data_request
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
