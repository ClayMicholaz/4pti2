<?php
session_start();
require_once __DIR__.'/../config/database.php';

class Auth extends Database{
    public function login($username, $password){
        $stmt = $this->conn->prepare(
            "SELECT * FROM tbl_users WHERE username=?"
        );
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if($user && password_verify($password,$user['password'])){
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }
    public static function cekLogin(){
        if(!isset($_SESSION['username'])){
            header("Location: /4pti2/auth/login.php");
            exit;
        }
    }
}