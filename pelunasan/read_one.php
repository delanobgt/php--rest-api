<?php

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: access");

//Include db and object

include_once '../config/database.php';
include_once '../objects/Pelunasan.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$pelunasan = new Pelunasan($db);

//Set ID of product to be edited
$pelunasan->id = isset($_GET['id']) ? $_GET['id']: die;

//Read details of edited product
$pelunasan->readOne();

//Create array
$pelunasan_arr = array(
    "id" => $pelunasan->id,
    "pinjaman_id" => $pelunasan->pinjaman_id,
    "tanggal" => $pelunasan->tanggal,
    "angsuran_ke" => $pelunasan->angsuran_ke,
    "jumlah_bayar" => $pelunasan->jumlah_bayar,
    "keterangan" => $pelunasan->keterangan
);

print_r(json_encode($pelunasan_arr));
