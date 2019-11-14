<?php

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../config/database.php';
include_once '../objects/pinjaman.php';

//Db conn and instances
$database = new Database();
$db = $database->getConnection();

$pinjaman = new Pinjaman($db);

$data = json_decode(file_get_contents("php://input"));

$pinjaman->debitur_id = $data->debitur_id;
$pinjaman->tanggal = $data->tanggal;
$pinjaman->jumlah_angsuran = $data->jumlah_angsuran;
$pinjaman->jumlah_pinjaman = $data->jumlah_pinjaman;
$pinjaman->keterangan = $data->keterangan;

if ($pinjaman->create()) {
    print(json_encode(['message' => 'Pinjaman saved.']));
} else {
    print(json_encode(['message' => 'Please try again.']));
}
