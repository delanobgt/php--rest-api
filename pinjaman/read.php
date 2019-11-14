<?php

//Required headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include db and object

include_once '../config/database.php';
include_once '../objects/Pinjaman.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$pinjaman = new Pinjaman($db);

$debitur_id = isset($_GET['debitur_id']) ? $_GET['debitur_id'] : die;

//Query products
$stmt = $pinjaman->read($debitur_id);
$num = $stmt->rowCount();

//Check if more than 0 record found
if ($num > 0) {

    //products array
    $pinjaman_arr = array();
    $pinjaman_arr["records"] = array();

    //retrieve table content
    // Difference fetch() vs fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $pinjaman_item = array(
            "id" => $id,
            "debitur_id" => $debitur_id,
            "tanggal" => $tanggal,
            "jumlah_angsuran" => $jumlah_angsuran,
            "jumlah_pinjaman" => $jumlah_pinjaman,
            "keterangan" => $keterangan
        );

        array_push($pinjaman_arr["records"], $pinjaman_item);
    }

    echo json_encode($pinjaman_arr);
} else {
    echo json_encode(
        array("messege" => "No pinjaman found.")
    );
}
