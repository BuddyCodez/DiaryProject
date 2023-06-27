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
$project_id = $result->fetch_assoc()['project_id'];
if (!$isLeader) {
    header("Location: /diaryproject/student_dashboard/edit_task.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/templates/header_students.php"; ?>

<body>
    <div class="wrapper">
        <div class="flex justify-between gap-4" style="width: 100%;padding: 0px 2%;">
            <div class="flex flex-col gap-2">
                <!-- <h1>Project id <?php echo $project_id ?></h1> -->
                <h1>Daily Tasks</h1>

                <?php if (!$projectExists) { ?>
                    <p>No project assigned to your team.</p>
                <?php } elseif ($projectExists) { ?>
                    <!-- Display the table for daily tasks -->
                    <div class="flex darkb rounded-xl">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Task Deadline</th>
                                    <th>Task Name</th>
                                    <th>Task Description</th>
                                    <th>Task Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM task WHERE project_id = '$project_id'";
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_array($result)) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['task_deadline']; ?>
                                            <br>
                                            <?php if ($row['task_status'] === 'Pending') { ?>
                                                <span class="badge badge-outline badge-warning">Pending</span>
                                            <?php } else { ?>
                                                <?php
                                                $deadlineTimestamp = strtotime($row['task_deadline']);
                                                $updateTimestamp = strtotime($row['updated_at']);
                                                if ($updateTimestamp > $deadlineTimestamp) {
                                                    echo "<span class='text-error'>";
                                                    echo "Submitted after deadline.";
                                                    echo "</span>";
                                                } else {
                                                    echo "<span class='text-success'>";
                                                    echo "Submitted on deadline.";
                                                    echo "</span>";
                                                }
                                                ?>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo $row['task_name']; ?></td>
                                        <td>
                                            <?php echo $row['task_description']; ?><br><br>
                                        </td>
                                        <td>
                                            <!-- If user is the team leader, allow task status update -->
                                            <?php if ($isLeader) { ?>
                                                <form action="update_task_status.php" method="POST" class="flex gap-2 items-center">
                                                    <input type="hidden" name="task_id" value="<?php echo $row['task_id']; ?>">
                                                    <select name="status" class="select">
                                                        <option value="Pending" class="text-white" <?php echo $row['task_status'] === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                        <option value="Completed" class="text-white" <?php echo $row['task_status'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                    </select>
                                                    <input type="submit" value="Update">
                                                    <a href="edit_task.php">Edit</a>
                                                </form>
                                            <?php } else { ?>
                                                <?php echo $row['task_status']; ?>
                                            <?php } ?>

                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>

            </div>
            <?php if ($isLeader) { ?>
                <!-- Form for adding a new task (only visible to team leader) -->
                <form action="add_task.php" method="POST" class="flex flex-col max-w-[40%] w-full gap-1">
                    <h2>Add New Task</h2>
                    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
                    <label for="task_name">Task Name:</label>
                    <input type="text" id="task_name" name="task_name" class="input input-bordered input-info w-full" required><br>
                    <label for="task_description">Task Description:</label>
                    <textarea id="task_description" name="task_description" rows="5" cols="30" required class="input input-bordered input-info w-full"></textarea><br>
                    <label for="task_description">Task Deadline:</label>

                    <input type="date" id="task_deadline" name="task_deadline" required class="input input-bordered input-info w-full"><br>

                    <input type="submit" value="Add Task" class="btn btn-info text-white">
                </form>
            <?php } ?>

        </div>
    </div>
</body>

</html>