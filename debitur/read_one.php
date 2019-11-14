<?php

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: access");

//Include db and object

include_once '../config/database.php';
include_once '../objects/Debitur.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$debitur = new Debitur($db);

//Set ID of product to be edited
$debitur->id = isset($_GET['id']) ? $_GET['id']: die;

//Read details of edited product
$debitur->readOne();

//Create array
$debitur_arr = array(
    "id" => $debitur->id,
    "no_ktp" => $debitur->no_ktp,
    "nama" => $debitur->nama,
    "alamat" => $debitur->alamat,
    "jenis_kelamin" => $debitur->jenis_kelamin
);

print_r(json_encode($debitur_arr));
