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
    public function changePassword($username, $new_password){
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE tbl_users SET password=? WHERE username=?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("ss", $hashed, $username);
        if($stmt->execute()){
            return $stmt->affected_rows > 0;
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