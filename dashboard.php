<?php
session_start();
if($_SESSION['role']=='admin'){
    header("location: dashboard_admin.php");
}else{
    header("location: dashboard_user.php");
}