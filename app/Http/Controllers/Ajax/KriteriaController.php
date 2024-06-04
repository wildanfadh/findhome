<?php

namespace App\Http\Controllers\Ajax;

use App\Enums\SifatKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class KriteriaController extends Controller
{
    public function index()
    {
        $data = Kriteria::all();

        $dataTable = Datatables::of($data)->addIndexColumn()
            ->addColumn('sifat', function ($data) {
                $result = SifatKriteria::fromValue($data->sifat);
                return $result->key;
            })
            ->addColumn('action', function ($data) {
                $urlSubKriteria = route('page.subkriteria.list_by_kriteria', $data->id);
                // ========== Action ==========
                $addSubBtn = "<a class='btn btn-sm btn-primary add-sub' href={$urlSubKriteria} data-single_source='{$data}'><i class='ti ti-list-details'></i></a>";
                // $addSubBtn = "<button class='btn btn-sm btn-info sub' data-single_source='{$data}'><i class='ti ti-list-details'></i> Sub</button>";
                $editBtn = "<button class='btn btn-sm btn-warning edit' data-single_source='{$data}'><i class='ti ti-pencil'></i></button>";
                $deleteBtn = "<button class='btn btn-sm btn-danger delete' data-single_source='{$data}'><i class='ti ti-trash'></i></button>";

                $actionBtn = $addSubBtn . $editBtn . $deleteBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->rawColumns(['sifat', 'action']);
        return $dataTable->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $data_request = [
                'nama' => $request->nama,
                'kode' => get_code_kriteria(),
                'sifat' => $request->sifat,
                'bobot' => $request->bobot,
                'keterangan' => $request->keterangan,
            ];
            Kriteria::create($data_request);

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

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // dd($id);
            $data = Kriteria::find($id);

            $data_request = [
                'nama' => $request->nama,
                'sifat' => $request->sifat,
                'bobot' => $request->bobot,
                'keterangan' => $request->keterangan,
            ];
            $data->update($data_request);

            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil diupdate',
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Kriteria::find($id);
            $data->delete();
            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil dihapus',
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
