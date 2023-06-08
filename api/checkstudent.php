<?php 
// Path: api\admincheck.php
session_start();
$username = $_SESSION['username'] ?? "";
$role = $_SESSION['role'] ?? "";
if(!isset($username)  || $role != "student"){
    // get path for login.php at root
    header("Location: http://localhost/diaryproject/");
}
?>