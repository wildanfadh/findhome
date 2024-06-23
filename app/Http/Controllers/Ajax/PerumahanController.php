<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Perumahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\KriteriaPerumahan;
use Yajra\DataTables\Facades\DataTables;

class PerumahanController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->roles);
        // $data = Perumahan::all();
        $data = Perumahan::with('images')->get();
        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                $activeBtn = '';
                // ========== Action ==========
                if ($data->is_verified == 1) {
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

    public function perumahanByPengembang()
    {
        $data = Perumahan::with('images')->where('pengembang_id', auth()->user()->dataPengembang->id)->get();
        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                $activeBtn = '';
                // ========== Action ==========
                if ($data->is_verified == 1) {
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
                $deleteBtn = "<button class='btn btn-sm btn-danger delete' data-single_source='{$data}'><i class='ti ti-trash'></i></button>";

                $actionBtn = $viewBtn . $editBtn . $deleteBtn;
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

            // reformat harga
            $request->merge(['harga' => str_replace('Rp ', '', $request->harga)]);
            $request->merge(['harga' => str_replace('.', '', $request->harga)]);
            $request->merge(['harga' => str_replace(',00', '', $request->harga)]);

            $data_request = [
                'kode' => get_code_perumahan(),
                'pengembang_id' => auth()->user()->dataPengembang->id,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'alamat' => $request->alamat,
                'lat_lang' => $request->latitude . ',' . $request->longitude,
                'keterangan' => $request->keterangan,
                'is_verified' => false,
            ];
            $data = Perumahan::create($data_request);
            // dd($data);

            // add perumahan image
            // if ($request->hasFile('gambar')) {
            //     $file = $request->file('gambar');
            //     $dir = "GAMBAR_PERUMAHAN";
            //     store_perumahan_image($data, $dir, $file);
            // }
            if ($request->hasFile('gambar')) {
                if (count($request->file('gambar')) <= 5) {

                    $dir = "GAMBAR_PERUMAHAN_" . strtoupper($data_request['nama']);

                    foreach ($request->file('gambar') as $key => $image) {

                        // add new file image
                        store_perumahan_images($data, $dir, $key, $image);
                    }
                } else {
                    return $this->conditionalResponse((object) [
                        'success' => false,
                        'message' => 'Maksimal 5 gambar',
                    ]);
                }
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
        // dd($request->file('gambar'));
        // dd($request, $id);
        DB::beginTransaction();
        try {
            $data = Perumahan::find($id);
            // dd($data);

            // reformat harga
            $request->merge(['harga' => str_replace('Rp ', '', $request->harga)]);
            $request->merge(['harga' => str_replace('.', '', $request->harga)]);
            $request->merge(['harga' => str_replace(',00', '', $request->harga)]);

            $data_request = [
                'pengembang_id' => auth()->user()->dataPengembang->id,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'alamat' => $request->alamat,
                'lat_lang' => $request->latitude . ',' . $request->longitude,
                'keterangan' => $request->keterangan,
                'is_verified' => false,
            ];
            $data->update($data_request);
            // dd($data);

            // add perumahan image
            if ($request->hasFile('gambar')) {
                if (count($request->file('gambar')) <= 5) {

                    $dir = "GAMBAR_PERUMAHAN_" . strtoupper($data_request['nama']);

                    // delete record and files
                    delete_perumahan_images($data->images(), $dir);

                    foreach ($request->file('gambar') as $key => $image) {

                        // add new file image
                        store_perumahan_images($data, $dir, $key, $image);
                    }
                } else {
                    return $this->conditionalResponse((object) [
                        'success' => false,
                        'message' => 'Maksimal 5 gambar',
                    ]);
                }
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

    public function request_kriteria_perumahan(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = KriteriaPerumahan::where(['perumahan_id' => $request->perumahan_id, 'kriteria_id' => $request->kriteria_id])->first();
            $data_request = [
                'perumahan_id' => $request->perumahan_id,
                'kriteria_id' => $request->kriteria_id,
                'sub_kriteria_id' => $request->sub_kriteria_id,
            ];

            if ($data) {
                $data->update($data_request);
            } else {
                $data = KriteriaPerumahan::create($data_request);
            }

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
            $data = Perumahan::find($id);

            if (!$data) {
                return $this->conditionalResponse((object) [
                    'success' => false,
                    'message' => 'Data Tidak ditemukan',
                    'data' => null
                ]);
            }

            // delete image if has image
            if ($data->images) {
                // $dir = "GAMBAR_PERUMAHAN";
                // delete_perumahan_image($data->image, $dir);
                $dir = "GAMBAR_PERUMAHAN_" . strtoupper($data['nama']);

                // delete record and files
                delete_perumahan_images($data->images(), $dir);
            }

            // delete kriteriaPerumahan if has kriteriaPerumahan
            $data->kriteriaPerumahan()->delete();

            $data->delete();
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
