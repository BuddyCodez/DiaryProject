<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";

if (!isset($_SESSION['enrollmentno'])) {
    header("Location: /diaryproject/login.php");
    exit();
}

$enrollmentno = $_SESSION['enrollmentno'];

// Get user's team ID
$query = "SELECT team_id FROM team WHERE FIND_IN_SET('$enrollmentno', en_no)";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$teamId = $row['team_id'];

// Check if the user is a team leader
$isLeader = isset($_SESSION['leader']) && $_SESSION['leader'] === true;
// Check if the project contains the ID for the user's team
$query = "SELECT * FROM team_project WHERE team_id = '$teamId'";
$result = mysqli_query($conn, $query);
$projectExists = mysqli_fetch_assoc($result);
// print_r($projectExists);
$projectExists = isset($projectExists['project_id']) ? true : false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Create a new project
    $projectName = $_POST['projectName'];
    $projectDescription = $_POST['projectDescription'];
    $id = rand(1, 9999);
    $query2 = "select * from project where id = '$id'";
    if (mysqli_num_rows(mysqli_query($conn, $query2)) > 0) {
        $id = rand(1, 9999);
    }
    $query = "INSERT INTO project (id, name, description) VALUES ('$id', '$projectName', '$projectDescription')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $query = "update team_project set project_id = '$id' where team_id = '$teamId'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            header("Location: /diaryproject/student_dashboard/my_project.php");
        }
    } else {
        echo "<script>alert('Error creating project')</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Project</title>
</head>

<?php include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/templates/header_students.php"; ?>

<body>
    <div class="wrapper mx-auto bg-slate-900 text-center">
        <h1>My Project</h1>
        
        <br>
        <?php if (!$projectExists) {
              
            
            ?>

            <!-- Display the form for creating a new project -->
            <?php if ($isLeader) { ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="flex flex-col center-j-i gap-4" style="width:50%;">
                    <div class="form-control  w-full">
                        <label class="label">
                            <span class="label-text">Project Name:</span>
                        </label>
                        <input type="text" name="projectName" class="input input-bordered" required>
                    </div>
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text">Project Description:</span>
                        </label>
                        <textarea name="projectDescription" class="textarea textarea-bordered" required></textarea>
                    </div>
                    <div class="form-control w-full">
                        <button type="submit" class="btn btn-info">Create Project</button>
                    </div>
                <?php } else { ?>
                    <p>You are not authorized to create a project.</p>
                <?php } ?>
            <?php } elseif ($projectExists) { ?>
                <!-- Display the table for the existing project -->
                <div class="flex darkb rounded-xl   ">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Project ID</th>
                                <th>Project Name</th>
                                <th>Project Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM Project WHERE id IN (SELECT project_id FROM team_project WHERE team_id = '$teamId')";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['approved'] ?? "Not Reviewed" ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>

    </div>

</body>

</html>