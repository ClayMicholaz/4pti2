<?php
class Database{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db ="hrisdb";
    public $conn;

    public function __construct(){
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );
        if($this->conn->connect_error){
            throw new Exception("Koneksi Gagal".$this->conn->connect_error);
    
        }
    }
}
// try{
//     $db = new Database();
//     echo "Koneksi Berhasil";
// }catch(Exception $e){
//     echo $e->getMessage();
// }