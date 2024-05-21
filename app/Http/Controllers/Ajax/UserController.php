<?php

namespace App\Http\Controllers\Ajax;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\RegisterUmumRequest;
use App\Http\Requests\RegisterPengembangRequest;

class UserController extends Controller
{
    public function index()
    {
        $data = User::with('roles')->get();
        $dataTable = DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($data) {
                // dd($data->roles[0]);
                $activeBtn = '';
                // ========== Action ==========
                if ($data->roles[0]->name != 'Admin') {
                    if ($data->is_active == 1) {
                        $activeBtn = "<button class='btn btn-sm btn-success btn-active' data-single_source='{$data}'>Active</button>";
                    } else {
                        $activeBtn = "<button class='btn btn-sm btn-danger btn-inactive' data-single_source='{$data}'>InActive</button>";
                    }
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

                $activeBtn = '';
                // ========== Action ==========
                if ($data->roles[0]->name != 'Admin') {
                    if ($data->is_active == 1) {
                        $activeBtn = "<button class='btn btn-sm btn-success btn-active' data-single_source='{$data}'>Active</button>";
                    } else {
                        $activeBtn = "<button class='btn btn-sm btn-danger btn-inactive' data-single_source='{$data}'>InActive</button>";
                    }
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

            // sertifikat
            if ($request->hasFile('sertifikat')) {
                $file = $request->file('sertifikat');
                $dir = "SERTIFIKAT_PENGEMBANG";
                store_file($data, $dir, $file);
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
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil diupdate',
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

            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil diupdate',
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

    public function active_nonactive(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $data = User::find($id);
            if ($id && !$data) return [
                "success" => false,
                "message" => "No data with ID $id",
            ];

            $data_requests = [
                "is_active" => $request->is_active,
            ];

            $data->update($data_requests);

            DB::commit();
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil diupdate',
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
            return $this->conditionalResponse((object) [
                'success' => true,
                'message' => 'Data Berhasil dihapus',
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
}
