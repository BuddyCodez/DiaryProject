<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";

if (!isset($_SESSION['enrollmentno'])) {
    header("Location: /diaryproject/login.php");
    exit();
}

$enrollmentno = $_SESSION['enrollmentno'];
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
$project_id = $result->fetch_assoc()['project_id'];
if (!$projectExists) {
    header("Location: /diaryproject/my_project.php");
    exit();
}
$query = "SELECT * FROM task WHERE project_id = '$project_id'";
$result = mysqli_query($conn, $query);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $task_id = $_POST['task_id'];
    $task_description = $_POST['task_description'];
    $status = $_POST['status'];
    $deadline = $_POST['deadline'];
    $query = "UPDATE task SET task_description = '$task_description', task_status = '$status', task_deadline = '$deadline' WHERE task_id = '$task_id'";
    mysqli_query($conn, $query);
    header("Location: edit_task.php");
    
}
?>
<!DOCTYPE html>
<html>

<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/templates/header_students.php"; ?>

<body>
    <div class="wrapper gap-2">
        <h1>Edit Task</h1>
        <div class="flex flex-col gap-1" style="width: 100%;padding: 0px 2%;">
            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <div class="collapse collapse-arrow bg-base-200">
                    <input type="radio" name="my-accordion-2" checked="checked" />
                    <div class="collapse-title text-xl font-medium">
                        <?php echo $row['task_name'] ?>
                    </div>
                    <div class="collapse-content">
                        <p>
                        <form action="edit_task.php" method="post" class="flex flex-col gap-2">
                            <label for="task_description">Task Description:</label>
                            <textarea id="task_description" name="task_description" rows="5" cols="30" required class="input input-bordered input-info w-full"><?php echo $row['task_description'] ?></textarea>
                            <?php if ($isLeader) {
                            ?>
                                <select name="status" class="select">
                                    <option value="Pending" class="text-white" <?php echo $row['task_status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="Completed" class="text-white" <?php echo $row['task_status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                </select>
                                <input type="date" name="deadline" value="<?php echo $row['task_deadline'] ?>" class="input input-bordered input-info w-full">
                            <?php
                            } ?>
                            <input type="hidden" name="task_id" value="<?php echo $row['task_id'] ?>">
                            <input type="submit" value="Update" class="btn btn-primary">
                        </form>
                        </p>
                    </div>
                </div>
            <?php
            }
            ?>

        </div>
    </div>
    <style>
        input[type="submit"] {
            background-color: hsl(var(--p) / 1);
        }
    </style>
</body>