<?php

//Required headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include db and object

include_once '../config/database.php';
include_once '../objects/Pelunasan.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$pelunasan = new Pelunasan($db);

$pinjaman_id = isset($_GET['pinjaman_id']) ? $_GET['pinjaman_id'] : die;

//Query products
$stmt = $pelunasan->read($pinjaman_id);
$num = $stmt->rowCount();

//Check if more than 0 record found
if ($num > 0) {

    //products array
    $pelunasan_arr = array();

    //retrieve table content
    // Difference fetch() vs fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $pelunasan_item = array(
            "id" => $id,
            "pinjaman_id" => $pinjaman_id,
            "tanggal" => $tanggal,
            "angsuran_ke" => $angsuran_ke,
            "jumlah_bayar" => $jumlah_bayar,
            "keterangan" => $keterangan
        );

        array_push($pelunasan_arr, $pelunasan_item);
    }

    echo json_encode($pelunasan_arr);
} else {
    echo json_encode(
        array("messege" => "No pelunasan found.")
    );
}
