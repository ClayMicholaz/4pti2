<?php
require_once "../core/Auth.php";

$auth = new Auth();
if(isset($_POST['login'])){
    if($auth->login($_POST['username'],$_POST['password'])){
        header("Location: /4pti2/dashboard.php");
    }else{
        echo "Login Gagal";
    }
}