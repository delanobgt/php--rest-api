<?php

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../config/database.php';
include_once '../objects/Debitur.php';

//Db conn and instances
$database = new Database();
$db = $database->getConnection();

$debitur = new Debitur($db);

$data = json_decode(file_get_contents("php://input"));

$debitur->no_ktp = $data->no_ktp;
$debitur->nama = $data->nama;
$debitur->alamat = $data->alamat;
$debitur->jenis_kelamin = $data->jenis_kelamin;

$lastId = $debitur->create();

if ($lastId !== null) {
    //Create array
    $debitur_arr = array(
        "id" => $lastId,
        "no_ktp" => $debitur->no_ktp,
        "nama" => $debitur->nama,
        "alamat" => $debitur->alamat,
        "jenis_kelamin" => $debitur->jenis_kelamin
    );

    print_r(json_encode($debitur_arr));
} else {
    print(json_encode(['message' => 'Please try again.']));
}
