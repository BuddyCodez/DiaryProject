<?php

include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
   
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $branch = $_POST['branch'];
    $query = "UPDATE faculty SET name = '$name', branch_id = '$branch', email = '$email', password = '$pass' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Scuccess";
        header("location: view_faculty.php");
    }
}
