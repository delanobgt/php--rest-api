<?php

/**
 *contains properties and methods for "debitur" database queries.
 */

class Pinjaman
{

    //Db connection and table
    private $conn;
    private $table_name = 'pinjaman';

    //Object properties
    public $id;
    public $debitur_id;
    public $tanggal;
    public $jumlah_angsuran;
    public $jumlah_pinjaman;

    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {

        // query to insert record
        $query = "INSERT INTO $this->table_name(debitur_id, tanggal, jumlah_angsuran, jumlah_pinjaman, keterangan)
                VALUES(:debitur_id, :tanggal, :jumlah_angsuran, :jumlah_pinjaman, :keterangan)";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->debitur_id = htmlspecialchars(strip_tags($this->debitur_id));
        $this->tanggal = htmlspecialchars(strip_tags($this->tanggal));
        $this->jumlah_angsuran = htmlspecialchars(strip_tags($this->jumlah_angsuran));
        $this->jumlah_pinjaman = htmlspecialchars(strip_tags($this->jumlah_pinjaman));
        $this->keterangan = htmlspecialchars(strip_tags($this->keterangan));

        // bind values
        $stmt->bindParam(":debitur_id", $this->debitur_id);
        $stmt->bindParam(":tanggal", $this->tanggal);
        $stmt->bindParam(":jumlah_angsuran", $this->jumlah_angsuran);
        $stmt->bindParam(":jumlah_pinjaman", $this->jumlah_pinjaman);
        $stmt->bindParam(":keterangan", $this->keterangan);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Read product
    function read($debitur_id)
    {
        //select all
        $query = "SELECT * FROM $this->table_name WHERE debitur_id = :debitur_id";

        //prepare
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":debitur_id", $debitur_id);

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
        $this->debitur_id = $row['debitur_id'];
        $this->tanggal = $row['tanggal'];
        $this->jumlah_angsuran = $row['jumlah_angsuran'];
        $this->jumlah_pinjaman = $row['jumlah_pinjaman'];
        $this->keterangan = $row['keterangan'];
    }
}
