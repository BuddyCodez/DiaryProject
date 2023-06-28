<?php

include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/checkfaculty.php";
$faculty_id = $_SESSION['faculty_id'];
$query = "SELECT * FROM team_project WHERE faculty_id = '$faculty_id'";
$result = mysqli_query($conn, $query);
$projectID = mysqli_fetch_assoc($result)['project_id'];


// Fetch tasks assigned to the faculty project from the database
$query = "SELECT * FROM task WHERE project_id = '$projectID'";
$result = mysqli_query($conn, $query);
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = $_POST['taskid'];
    $remarks = $_POST['remarks'];
    $query = "UPDATE task SET task_remarks = '$remarks' WHERE task_id = '$task_id'";
    $result = mysqli_query($conn, $query);
    header("location: view_tasks.php");
}
?>

<!-- HTML code for displaying tasks -->
<html>
<!-- ... -->

<?php include '../templates/header_faculty.php'; ?>

<body>
    <!-- ... -->
    <div class="wrapper">
        <div class="darkb p-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Submission</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task) { ?>
                        <tr>
                            <td><?php echo $task['task_name']; ?></td>
                            <td><?php echo $task['task_description']; ?></td>
                            <td><?php echo $task['task_deadline']; ?></td>
                            <td><?php echo $task['task_status']  ?? 'Not Added'; ?></td>
                            <td>
                                <?php if ($task['task_status'] === 'Pending') { ?>
                                    <span class="badge badge-outline badge-warning">Not submitted</span>
                                <?php } else { ?>
                                    <?php
                                    $deadlineTimestamp = strtotime($task['task_deadline']);
                                    $updateTimestamp = strtotime($task['updated_at']);
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
                            <td>
                                <form action="view_tasks.php" method="post" class="flex gap-4 center-j-i mt-3">
                                    <input type="hidden" name="taskid" value="<?php echo $task['task_id']; ?>">
                                    <textarea name="remarks" cols="30" rows="10" class="input input-bordered input-info text-white" placeholder="Enter remarks"><?php echo $task['task_remarks']; ?></textarea>
                                    <button type="submit" class="btn btn-info"><i class="fa-sharp fa-solid fa-pen-to-square"></i>Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- ... -->
</body>

</html>