<?php

function head_source($params)
{
    $source = [
        "DATATABLESBS5" => 'assets/libs/datatables/dataTables.bootstrap5.css',
        "SWEETALERT2" => 'assets/libs/sweetalert2/sweetalert2.min.css',
        "SELECT2" => 'assets/libs/select2/select2.min.css',
        "SELECT2BS4" => 'assets/libs/select2/select2-bootstrap.min.css',
    ];

    // get by params
    $result = [];
    if (isset($params)) {
        foreach ($params as $key => $param) {
            $result[] = asset($source[$param]);
        }
    }

    return $result; // bisa dibuat object atau array
}

function script_source($params)
{
    $source = [
        "DATATABLES" => 'assets/libs/datatables/dataTables.js',
        "DATATABLESBS5" => 'assets/libs/datatables/dataTables.bootstrap5.js',
        "SWEETALERT2" => 'assets/libs/sweetalert2/sweetalert2.all.min.js',
        "BLOCKUI" => 'assets/libs/blockui/jquery.blockUI.js',
        "SELECT2" => 'assets/libs/select2/select2.min.js',
        // "SELECT2BS5" => 'assets/vendors/select2/select2-bootstrap-5-theme.min.js',
        // "CUSTOMCURRENCYFORMAT" => 'js/customs/currency_format.js',
        // "CUSTOMDOCUMENT" => 'js/customs/document.js',
    ];

    // get by params
    $result = [];
    if (isset($params)) {
        foreach ($params as $key => $param) {
            $result[] = asset($source[$param]);
        }
    }

    return $result; // bisa dibuat object atau array
}
