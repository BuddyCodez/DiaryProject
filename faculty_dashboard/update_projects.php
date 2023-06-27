<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(!isset($_GET['projectid']) || !isset($_GET['action'])) return header("Location: view_project.php");
    $pid = $_GET['projectid'];
    $action = $_GET['action'];
    $approved = $action == 'a' ? 1 : 0;
    $query = "UPDATE project SET  approved = '$approved' WHERE id = '$pid'";
    mysqli_query($conn, $query);
    header("Location: view_project.php");
}
?>