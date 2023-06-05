<?php
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/connection.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `students` WHERE `email` = '$email' AND `password` = '$password'";
    $result = mysqli_query($conn, $sql);
    // verify password
    $row = mysqli_fetch_assoc($result);
    
    if (!$result) {
        $sql = "SELECT * FROM `faculties` WHERE `email` = '$email' AND `password` = '$password'";
        $result = mysqli_query($conn, $sql);
    }
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $row['name'];
        $_SESSION['role'] = "student";
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        header("location: ./index.php");
    } else {
        echo "<script>alert('Invalid Credentials')</script>";
    }
}
?>