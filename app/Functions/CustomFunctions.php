<?php

use App\Models\Kriteria;
use App\Models\Perumahan;
use Illuminate\Support\Facades\Storage;

function store_sertifikat($data, $dir, $filereq)
{
    // dd($data, $dir, $filereq);
    $path = 'public/' . $dir . '/';
    $pathDb = 'storage/' . $dir . '/';
    $originalName = $filereq->getClientOriginalName();

    $nama_pengembang = str_replace(array(
        '/', '"', "'",
        '.', ';', '<', '>', ' '
    ), '-', $data->name);
    $name = 'Sertifikat-' . $nama_pengembang . '.' . $filereq->getClientOriginalExtension();

    // save image
    $result = Storage::disk('local')->put($path . $name, file_get_contents($filereq));

    if ($result) {
        $requestFile = [
            'pengembang_id' => $data->id,
            'name' => $name,
            'original_name' => $originalName,
            'path' => $pathDb,
            'mime' => $filereq->getMimeType(),
            'created_at' => now()
        ];
        $resultFile = $data->dataPengembang->file()->insert($requestFile);
    }

    return $resultFile;
}

function store_perumahan_image($data, $dir, $filereq)
{
    // dd($data, $dir, $filereq);
    $path = 'public/' . $dir . '/';
    $pathDb = 'storage/' . $dir . '/';
    $originalName = $filereq->getClientOriginalName();

    $nama_perumahan = str_replace(array(
        '/', '"', "'",
        '.', ';', '<', '>', ' '
    ), '-', $data->nama);
    $name = 'Proyek-Perumahan-' . $nama_perumahan . '.' . $filereq->getClientOriginalExtension();

    // save image
    $result = Storage::disk('local')->put($path . $name, file_get_contents($filereq));

    if ($result) {
        $requestFile = [
            'perumahan_id' => $data->id,
            'name' => $name,
            'original_name' => $originalName,
            'path' => $pathDb,
            'mime' => $filereq->getMimeType(),
            'created_at' => now()
        ];
        $resultFile = $data->image()->insert($requestFile);
    }

    return $resultFile;
}

function store_perumahan_images($data, $dir, $no, $filereq)
{
    // dd($data, $dir, $filereq);
    $path = 'public/' . $dir . '/';
    $pathDb = 'storage/' . $dir . '/';
    $originalName = $filereq->getClientOriginalName();

    $nama_perumahan = str_replace(array(
        '/', '"', "'",
        '.', ';', '<', '>', ' '
    ), '-', $data->nama);
    $name = 'Proyek-Perumahan-' . $nama_perumahan . '_' . $no . '.' . $filereq->getClientOriginalExtension();

    // save image
    $result = Storage::disk('local')->put($path . $name, file_get_contents($filereq));

    if ($result) {
        $requestFile = [
            'perumahan_id' => $data->id,
            'name' => $name,
            'original_name' => $originalName,
            'path' => $pathDb,
            'mime' => $filereq->getMimeType(),
            'created_at' => now()
        ];
        $resultFile = $data->images()->insert($requestFile);
    }

    return $resultFile;
}

function delete_perumahan_image($data, $dir)
{
    // dd($data, $dir);
    $path = 'public/' . $dir . '/';
    $file = $path . $data->name;
    //  delete file
    Storage::delete($file);

    // delete record
    $result = $data->delete();

    return $result;
}
function delete_perumahan_images($data, $dir)
{
    // dd($data, $dir);
    $path = 'public/' . $dir . '/';
    //  delete folder
    Storage::deleteDirectory($path);

    // delete record
    $result = $data->delete();

    return $result;
}

function generate_key_matrix($string)
{
    $result = str_replace(array(
        '/', '"', "'",
        '.', ';', '<', '>', ' '
    ), '-', $string);

    return strtolower($result);
}

function get_code_perumahan()
{
    $kriteria = Perumahan::latest('id')->first();
    $kode = "A" . (int)substr($kriteria->kode, strpos($kriteria->kode, "_") + 1) + 1;
    return $kode;
}

function get_code_kriteria()
{
    $kriteria = Kriteria::latest('id')->first();
    $kode = "K" . (int)substr($kriteria->kode, strpos($kriteria->kode, "_") + 1) + 1;
    return $kode;
}
