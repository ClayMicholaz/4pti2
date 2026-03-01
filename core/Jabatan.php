<?php
require_once __DIR__.'/../config/database.php';

class Jabatan extends Database{
    public function getAll($limit, $offset){
        return $this->conn->query(
            "Select * From tbl_jabatan
            Order by id DESC LIMIT $limit OFFSET $offset"
        );
    }
    public function count(){
        $q = $this->conn->query(
            "SELECT COUNT(*) as total 
            FROM tbl_jabatan"
        );
        return $q->fetch_assoc()['total'];       
    }
    public function insert($nama){
        $stmt = $this->conn->prepare(
            "INSERT INTO tbl_jabatan(namajab) VALUES(?)"
        );
        $stmt->bind_param("s",$nama);
        return $stmt->execute();
    }
    public function find($id){
        $q = $this->conn->query(
            "SELECT * FROM tbl_jabatan WHERE id=$id"
        );
        return $q->fetch_assoc();
    }
    public function update($id,$nama){
        $stmt = $this->conn->prepare(
            "UPDATE tbl_jabatan SET namajab=? WHERE id=?"
        );
        $stmt->bind_param("si",$nama, $id);
        return $stmt->execute();
    }
    public function delete($id){
        return $this->conn->query(
            "DELETE FROM tbl_jabatan WHERE id=$id"
        );
    }
}