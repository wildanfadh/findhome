<?php

namespace App\Http\Controllers\Ajax;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterPengembangRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterUmumRequest;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $data = User::with('roles')->get();
        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {

                // ========== Action ==========
                if ($data->is_active) {
                    $activeBtn = "<button class='btn btn-sm btn-success active' data-single_source='{$data}'>Active</button>";
                } else {
                    $activeBtn = "<button class='btn btn-sm btn-danger inactive' data-single_source='{$data}'>InActive</button>";
                }

                $actionBtn = $activeBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->rawColumns(['action']);
        return $dataTable->make(true);
    }

    public function pengembang()
    {
        $data = User::with('roles')->get();
        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('alamat', function ($data) {
                $alamat = 'Alamat';
                return $alamat;
            })
            ->addColumn('action', function ($data) {

                // ========== Action ==========
                if ($data->is_active) {
                    $activeBtn = "<button class='btn btn-sm btn-success active' data-single_source='{$data}'>Active</button>";
                } else {
                    $activeBtn = "<button class='btn btn-sm btn-danger inactive' data-single_source='{$data}'>InActive</button>";
                }

                $actionBtn = $activeBtn;
                // ========== End Action ==========

                return $actionBtn;
            })->rawColumns(['action']);
        return $dataTable->make(true);
    }

    public function register_umum(RegisterUmumRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = new User;
            $role = Role::where('name', 'Umum')->first();
            $data_requests = [
                "name" => $request->name,
                "username" => $request->username,
                "no_hp" => $request->no_hp,
                "email" => $request->email,
            ];
            $data_requests['password'] = Hash::make($request->password);
            $last = $data->create($data_requests);

            // add role
            $last->assignRole([$role->id]);

            DB::commit();
            return [
                "success" => true,
                "message" => "Data berhasil ditambahkan",
                "data" => $data_requests,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public function register_pengembang(RegisterPengembangRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = new User;
            $role = Role::where('name', 'Pengembang')->first();
            $data_requests = [
                "name" => $request->name,
                "username" => $request->username,
                "no_hp" => $request->no_hp,
                "email" => $request->email,
            ];

            $data_pengembang_request = [
                "alamat" => $request->alamat,
                "is_verified" => false,
            ];

            $data_requests['password'] = Hash::make($request->password);
            $last = $data->create($data_requests);

            // add data pengembang
            $last->dataPengembang()->create($data_pengembang_request);

            // add role
            $last->assignRole([$role->id]);

            DB::commit();
            return [
                "success" => true,
                "message" => "Data berhasil ditambahkan",
                "data" => $data_requests,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public function update(RegisterUmumRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = User::find($id);
            $data_requests = [
                "name" => $request->name,
                "username" => $request->username,
                "no_hp" => $request->no_hp,
                "email" => $request->email,
            ];
            $data->update($data_requests);

            DB::commit();
            return [
                "success" => true,
                "message" => "Data berhasil diupdate",
                "data" => $data_requests,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public function update_password(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = User::find($id);

            if ($id && !$data) return [
                "success" => false,
                "message" => "No data with ID $id",
            ];

            $data_requests = [
                "password" => Hash::make($request->password),
            ];

            $data->update($data_requests);

            DB::commit();

            return [
                "success" => true,
                "message" => $id ? "Data berhasil diupdate" : "Data berhasil ditambahkan",
                "data" => $data_requests,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = User::find($id);

            // Check the data
            if ($id && !$data) return [
                "success" => false,
                "message" => "No data with ID $id",
            ];

            $data->delete();

            DB::commit();
            return [
                "success" => true,
                "message" => "Data berhasil dihapus",
                "data" => null,
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                "success" => false,
                "message" => $e->getMessage(),
            ];
        }
    }
}
