<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['enrollment'])) {
        $enrollment = $_GET['enrollment'];
        $query = "DELETE FROM students WHERE enrollmentno = '$enrollment'";
        if($enrollment == "all") {
            $query = "DELETE FROM students";
        }
        $result = mysqli_query($conn, $query);
        if($result) {
            header("Location: students.php");
        }
    }
}
