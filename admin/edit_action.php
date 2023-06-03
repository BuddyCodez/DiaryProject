<?php

include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/admincheck.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $enrollmentno = $_POST['enrollmentno'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $branch = $_POST['branch'];
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);
    $studentId = $_POST['id'];

    $query = "UPDATE students SET name = '$name', enrollmentno = '$enrollmentno', branch_id = '$branch', email = '$email', password = '$hashedPassword' WHERE id = $studentId";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "Scuccess";
        header("location: students.php");
    }
}
