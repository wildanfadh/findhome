<?php

use Illuminate\Support\Facades\Storage;

function store_file($data, $dir, $filereq)
{
    // dd($data, $dir, $filereq);
    $path = 'public/' . $dir . '/';
    $pathDb = 'storage/' . $dir . '/';
    $originalName = $filereq->getClientOriginalName();
    // FIL: no_sppd(special karakter ganti '-') + - + nama_dokumen(special karakter ganti '-', spasi diganti '') + - + urutan

    $nama_pengembang = str_replace(array(
        '/', '"', "'",
        '.', ';', '<', '>', ' '
    ), '-', $data->name);
    // dd($nama_pengembang, $nama_dokumen);
    $name = $nama_pengembang . '.' . $filereq->getClientOriginalExtension();

    // save image
    $result = Storage::disk('local')->put($path . $name, file_get_contents($filereq));

    // dd($result);
    if ($result) {
        $requestFile = [
            'pengembang_id' => $data->id,
            'name' => $name,
            'original_name' => $originalName,
            'path' => $pathDb,
            'mime' => $filereq->getMimeType(),
            'created_at' => now()
        ];
        $resultFile = $data->file()->insert($requestFile);
    }

    return $resultFile;
}
