<?php

namespace App\Http\Controllers\Ajax;

use App\Models\SubKriteria;
use App\Enums\SifatKriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $data = SubKriteria::all();

        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {

                // ========== Action ==========
                $editBtn = "<button class='btn btn-sm btn-warning edit-sub' data-single_source='{$data}'><i class='ti ti-pencil'></i></button>";
                $deleteBtn = "<button class='btn btn-sm btn-danger delete-sub' data-single_source='{$data}'><i class='ti ti-trash'></i></button>";

                $actionBtn = $editBtn . $deleteBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->rawColumns(['sifat', 'action']);
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
