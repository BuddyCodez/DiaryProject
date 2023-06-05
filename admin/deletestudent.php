<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/admincheck.php";
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "DELETE FROM students WHERE id = '$id'";
        if($id == "all") {
            $query = "DELETE FROM students";
        }
        $result = mysqli_query($conn, $query);
        if($result) {
            header("Location: students.php");
        }
    }
}
?>