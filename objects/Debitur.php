<?php

/**
 *contains properties and methods for "debitur" database queries.
 */

class Debitur
{

    //Db connection and table
    private $conn;
    private $table_name = 'debitur';

    //Object properties
    public $id;
    public $no_ktp;
    public $nama;
    public $alamat;
    public $jenis_kelamin;

    //Constructor with db conn
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {

        // query to insert record
        $query = "INSERT INTO $this->table_name(no_ktp, nama, alamat, jenis_kelamin)
                VALUES(:no_ktp, :nama, :alamat, :jenis_kelamin)";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->no_ktp = htmlspecialchars(strip_tags($this->no_ktp));
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->jenis_kelamin = htmlspecialchars(strip_tags($this->jenis_kelamin));

        // bind values
        $stmt->bindParam(":no_ktp", $this->no_ktp);
        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":jenis_kelamin", $this->jenis_kelamin);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    //Read product
    function read()
    {

        //select all
        $query = "SELECT * FROM $this->table_name";

        //prepare
        $stmt = $this->conn->prepare($query);

        //execute
        $stmt->execute();

        return $stmt;
    }


    //read single product
    function readOne()
    {

        //read single record
        $query = "SELECT * FROM $this->table_name WHERE id = :id";

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
        $this->no_ktp = $row['no_ktp'];
        $this->nama = $row['nama'];
        $this->alamat = $row['alamat'];
        $this->jenis_kelamin = $row['jenis_kelamin'];
    }
}
