<?php 
session_start();
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/connection.php";
if($_SESSION['role'] == "admin" && $_SESSION['username']) {
} else {
    header("location: ./login.php");

}
?>