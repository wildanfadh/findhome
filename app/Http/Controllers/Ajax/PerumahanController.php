<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Perumahan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PerumahanController extends Controller
{
    public function index()
    {
        $data = Perumahan::all();
        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('status', function ($data) {
                $activeBtn = '';
                // ========== Action ==========
                if ($data->is_active == 1) {
                    $activeBtn = "<button class='btn btn-sm btn-success btn-active' data-single_source='{$data}'>Active</button>";
                } else {
                    $activeBtn = "<button class='btn btn-sm btn-danger btn-inactive' data-single_source='{$data}'>Proses Verifikasi</button>";
                }

                $actionBtn = $activeBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->addColumn('action', function ($data) {

                // ========== Action ==========
                $editBtn = "<button class='btn btn-sm btn-warning edit' data-single_source='{$data}'><i class='ti ti-pencil'></i></button>";
                // $deleteBtn = "<button class='btn btn-sm btn-danger delete' data-single_source='{$data}'><i class='ti ti-trash'></i></button>";

                $actionBtn = $editBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->rawColumns(['action']);
        return $dataTable->make(true);
    }

    public function store(Request $request)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
