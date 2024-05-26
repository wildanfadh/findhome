<?php

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
