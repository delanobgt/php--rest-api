<?php

/**
 *contains properties and methods for "debitur" database queries.
 */

class Pelunasan
{

    //Db connection and table
    private $conn;
    private $table_name = 'pelunasan';

    //Object properties
    public $id;
    public $pinjaman_id;
    public $tanggal;
    public $angsuran_ke;
    public $jumlah_bayar;
    public $keterangan;

    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {

        // query to insert record
        $query = "INSERT INTO $this->table_name (pinjaman_id, tanggal, angsuran_ke, jumlah_bayar, keterangan)
                VALUES(:pinjaman_id, :tanggal, :angsuran_ke, :jumlah_bayar, :keterangan)";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->pinjaman_id = htmlspecialchars(strip_tags($this->pinjaman_id));
        $this->tanggal = htmlspecialchars(strip_tags($this->tanggal));
        $this->angsuran_ke = htmlspecialchars(strip_tags($this->angsuran_ke));
        $this->jumlah_bayar = htmlspecialchars(strip_tags($this->jumlah_bayar));
        $this->keterangan = htmlspecialchars(strip_tags($this->keterangan));

        // bind values
        $stmt->bindParam(":pinjaman_id", $this->pinjaman_id);
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":angsuran_ke", $this->angsuran_ke);
        $stmt->bindParam(":jumlah_bayar", $this->jumlah_bayar);
        $stmt->bindParam(":keterangan", $this->keterangan);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function read($pinjaman_id)
    {

        //select all
        $query = "SELECT * FROM $this->table_name WHERE pinjaman_id = :pinjaman_id";

        //prepare
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pinjaman_id", $pinjaman_id);

        //execute
        $stmt->execute();

        return $stmt;
    }


    //read single product
    function readOne()
    {

        //read single record
        $query = "SELECT * FROM $this->table_name WHERE id=:id";

        //prepare
        $stmt = $this->conn->prepare($query);

        //bind id of product
        $stmt->bindParam(":id", $this->id);

        //execute
        $stmt->execute();

        //fetch row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values to update
        $this->id = $row['id'];
        $this->pinjaman_id = $row['pinjaman_id'];
        $this->tanggal = $row['tanggal'];
        $this->angsuran_ke = $row['angsuran_ke'];
        $this->jumlah_bayar = $row['jumlah_bayar'];
        $this->keterangan = $row['keterangan'];
    }
}
