<?php

//Required headers

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Include db and object

include_once '../config/database.php';
include_once '../objects/Debitur.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$debitur = new Debitur($db);

//Query products
$stmt = $debitur->read();
$num = $stmt->rowCount();

//Check if more than 0 record found
if ($num > 0) {

    //products array
    $debitur_arr = array();

    //retrieve table content
    // Difference fetch() vs fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $debitur_item = array(
            "id"                =>  $id,
            "no_ktp"            =>  $no_ktp,
            "nama"              =>  $nama,
            "alamat"            =>  $alamat,
            "jenis_kelamin"     =>  $jenis_kelamin,
        );

        array_push($debitur_arr, $debitur_item);
    }

    echo json_encode($debitur_arr);
} else {
    echo json_encode(
        array("messege" => "No debitur found.")
    );
}
