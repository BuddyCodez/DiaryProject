<?php 
// Path: api\admincheck.php
session_start();
$username = $_SESSION['username'] ?? "";
$role = $_SESSION['role'] ?? "";
if($username == "" && !isset($username)  || $role != "faculty"){
    header("location: ../login.php");
}
