<?php 
session_start();
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
print_r($_SESSION);
if($_SESSION['username'] or $_SESSION['email']) {
    $_SESSION['role'] == "student" ? header("location: ./student_dashboard/index.php") : header("location: ./faculty_dashboard/index.php");
} else {
    header("location: ./login.php");
}
?>