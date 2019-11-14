<?php

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: access");

//Include db and object

include_once '../config/database.php';
include_once '../objects/Pinjaman.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$pinjaman = new Pinjaman($db);

//Set ID of product to be edited
$pinjaman->id = isset($_GET['id']) ? $_GET['id']: die;

//Read details of edited product
$pinjaman->readOne();

//Create array
$pinjaman_arr = array(
    "id" => $pinjaman->id,
    "debitur_id" => $pinjaman->debitur_id,
    "tanggal" => $pinjaman->tanggal,
    "jumlah_angsuran" => $pinjaman->jumlah_angsuran,
    "jumlah_pinjaman" => $pinjaman->jumlah_pinjaman,
    "input_date" => $pinjaman->input_date
);

print_r(json_encode($pinjaman_arr));
