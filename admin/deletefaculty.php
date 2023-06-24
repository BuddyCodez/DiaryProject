<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        $query = "DELETE FROM faculty WHERE email = '$email'";
        if ($email == "all") {
            $query = "DELETE FROM faculty ";
        }
        $result = mysqli_query($conn, $query);
        if ($result) {
            header("Location: view_faculty.php");
        }
    }
}
