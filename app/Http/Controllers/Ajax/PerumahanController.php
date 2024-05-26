<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Perumahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PerumahanController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->roles);
        // $data = Perumahan::all();
        $data = Perumahan::with('image')->get();
        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                $activeBtn = '';
                // ========== Action ==========
                if ($data->is_active == 1) {
                    $activeBtn = "<span class='badge badge-sm text-bg-success' data-single_source='{$data}'>Aktif</span>";
                } else {
                    $activeBtn = "<span class='badge badge-sm text-bg-muted' data-single_source='{$data}'>Proses Verifikasi</span>";
                }

                $actionBtn = $activeBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->addColumn('action', function ($data) {
                $urlKriteria = route('page.perumahan.detail_kriteria', $data->id);
                $urlDetail = route('page.perumahan.detail', $data->id);
                // ========== Action ==========
                // $viewKriteriaBtn = "<a class='btn btn-sm btn-info view-kriteria' href={$urlKriteria} data-single_source='{$data}'><i class='ti ti-list-numbers'></i></a>";
                $viewBtn = "<a class='btn btn-sm btn-info view-detail' href={$urlDetail} data-single_source='{$data}'><i class='ti ti-id'></i></a>";
                $editBtn = "<button class='btn btn-sm btn-warning edit' data-single_source='{$data}'><i class='ti ti-pencil'></i></button>";
                // $deleteBtn = "<button class='btn btn-sm btn-danger delete' data-single_source='{$data}'><i class='ti ti-trash'></i></button>";

                $actionBtn = $viewBtn . $editBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->rawColumns(['status', 'action']);
        return $dataTable->make(true);
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        try {
            $data_request = [
                'pengembang_id' => auth()->user()->id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'keterangan' => $request->keterangan,
                'is_verified' => false,
            ];
            $data = Perumahan::create($data_request);
            // dd($data);

            // add perumahan image
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $dir = "GAMBAR_PERUMAHAN";
                store_perumahan_image($data, $dir, $file);
            }
            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil ditambahkan',
                'data' => $data
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
        // dd($request, $id);
        DB::beginTransaction();
        try {
            $data = Perumahan::find($id);
            // dd($data);
            $data_request = [
                'pengembang_id' => auth()->user()->id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'keterangan' => $request->keterangan,
                'is_verified' => false,
            ];
            $data->update($data_request);
            // dd($data);

            // add perumahan image
            if ($request->hasFile('gambar')) {

                $perumahan_image = $data->image;

                $dir = "GAMBAR_PERUMAHAN";

                // delete record and files
                if ($perumahan_image) {
                    delete_perumahan_image($perumahan_image, $dir);
                }

                // add new file image
                $file = $request->file('gambar');
                store_perumahan_image($data, $dir, $file);
            }
            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil ditambahkan',
                'data' => $data
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
    }
}
