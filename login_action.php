<?php
session_start();
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `students` WHERE `email` = '$email' AND `password` = '$password'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        $sql = "SELECT * FROM `faculties` WHERE `email` = '$email' AND `password` = '$password'";
        $result = mysqli_query($conn, $sql);
        if(!$result) return;
        $row = $result->fetch_assoc();
        $_SESSION['role'] = "faculty";
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['name'];
        $_SESSION['email'] = $row['email'];
    } else {
        $row = $result->fetch_assoc();
        $_SESSION['role'] = "student";
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['name'];
        $_SESSION['email'] = $row['email'];
    }
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        header("location: ./index.php");
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
