<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Enums\SifatKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SubKriteriaController extends Controller
{
    // public function index()
    // {
    //     $data = SubKriteria::all();

    //     $dataTable = DataTables::of($data)->addIndexColumn()
    //         ->addColumn('action', function ($data) {

    //             // ========== Action ==========
    //             $editBtn = "<button class='btn btn-sm btn-warning edit-sub' data-single_source='{$data}'><i class='ti ti-pencil'></i></button>";
    //             $deleteBtn = "<button class='btn btn-sm btn-danger delete-sub' data-single_source='{$data}'><i class='ti ti-trash'></i></button>";

    //             $actionBtn = $editBtn . $deleteBtn;
    //             // ========== End Action ==========

    //             return $actionBtn;
    //         })->rawColumns(['action']);
    //     return $dataTable->make(true);
    // }

    public function data_by_kriteria(Request $request, $id_kriteria)
    {
        $data = Kriteria::find($id_kriteria)->subKriterias;
        // dd($data);

        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {

                // ========== Action ==========
                $editBtn = "<button class='btn btn-sm btn-warning edit-sub' data-single_source='{$data}'><i class='ti ti-pencil'></i></button>";
                $deleteBtn = "<button class='btn btn-sm btn-danger delete-sub' data-single_source='{$data}'><i class='ti ti-trash'></i></button>";

                $actionBtn = $editBtn . $deleteBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->rawColumns(['action']);
        return $dataTable->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $data_request = [
                'kriteria_id' => $request->kriteria_id,
                'uraian' => $request->uraian,
                'nilai' => $request->nilai,
            ];
            SubKriteria::create($data_request);

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
            $data = SubKriteria::find($id);

            $data_request = [
                'kriteria_id' => $request->kriteria_id,
                'uraian' => $request->uraian,
                'nilai' => $request->nilai,
            ];
            $data->update($data_request);

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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = SubKriteria::find($id);
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
