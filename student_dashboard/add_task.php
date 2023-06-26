<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";

if (!isset($_SESSION['enrollmentno'])) {
    header("Location: /diaryproject/login.php");
    exit();
}

$enrollmentno = $_SESSION['enrollmentno'];

// Retrieve user's team ID
$query = "SELECT team_id FROM team WHERE FIND_IN_SET('$enrollmentno', en_no)";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$teamId = $row['team_id'];

// Check if the user is a team leader
$isLeader = isset($_SESSION['leader']) && $_SESSION['leader'] === true;

// Check if the project contains the ID for the user's team
$query = "SELECT * FROM team_project WHERE team_id = '$teamId'";
$result = mysqli_query($conn, $query);
$projectExists = mysqli_num_rows($result) > 0;

if (!$isLeader || !$projectExists) {
    header("Location: /diaryproject/daily_tasks.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_id = $_POST['project_id'];
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_id = rand(100000, 999999);
    $task_deadline = $_POST['task_deadline'];

    if($conn->query("SELECT * FROM task WHERE task_id = '$task_id'")){
        $task_id = rand(100000, 999999);
    }
    // Insert the new task into the task table
    $insertQuery = "INSERT INTO task (task_id,project_id, task_name, task_description, task_status, task_deadline) VALUES ('$task_id','$project_id', '$task_name', '$task_description', 'Pending', '$task_deadline')";
    mysqli_query($conn, $insertQuery);

    // Redirect back to the daily tasks page
    header("Location: daily_task.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Task</title>
</head>

<body>
    <h1>Add New Task</h1>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
        <label for="task_name">Task Name:</label>
        <input type="text" id="task_name" name="task_name" required><br>
        <label for="task_description">Task Description:</label>
        <textarea id="task_description" name="task_description" rows="5" cols="30" required></textarea><br>
        <input type="submit" value="Add Task">
    </form>

    <p><a href="/diaryproject/daily_tasks.php">Back to Daily Tasks</a></p>

</body>

</html>