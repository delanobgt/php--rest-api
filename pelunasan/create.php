<?php

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../config/database.php';
include_once '../objects/pelunasan.php';

//Db conn and instances
$database = new Database();
$db = $database->getConnection();

$pelunasan = new Pelunasan($db);

$data = json_decode(file_get_contents("php://input"));

$pelunasan->pinjaman_id = $data->pinjaman_id;
$pelunasan->tanggal = $data->tanggal;
$pelunasan->angsuran_ke = $data->angsuran_ke;
$pelunasan->jumlah_bayar = $data->jumlah_bayar;
$pelunasan->keterangan = $data->keterangan;

if ($pelunasan->create()) {
    print(json_encode(['message' => 'Pelunasan saved.']));
} else {
    print(json_encode(['message' => 'Please try again.']));
}
