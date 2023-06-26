<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['task_id']) && isset($_POST['status'])) {
        $taskID = $_POST['task_id'];
        $status = $_POST['status'];

        // Update the task status in the database
        $query = "UPDATE task SET task_status = '$status' WHERE task_id = '$taskID'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Task status updated successfully
            header("Location: /diaryproject/student_dashboard/daily_task.php");
            exit();
        } else {
            // Error occurred while updating task status
            echo "Error updating task status. Please try again.";
        }
    } else {
        // Required parameters not provided
        echo "Invalid request. Please provide task ID and status.";
    }
} else {
    // Invalid request method
    echo "Invalid request method. Please use POST.";
}
