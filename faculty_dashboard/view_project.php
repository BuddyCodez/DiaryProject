<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/checkfaculty.php";


// get all data from  students table
$faculty_id = $_SESSION['faculty_id'];
$query = "SELECT * FROM team_project where faculty_id = '$faculty_id'";
$result = mysqli_query($conn, $query);
$project_id = $result->fetch_assoc()['project_id'];
$query = "SELECT * FROM project where id = '$project_id'";
$result = mysqli_query($conn, $query);
$project = mysqli_fetch_all($result, MYSQLI_ASSOC);
$total_project = mysqli_num_rows($result);
mysqli_free_result($result);
mysqli_close($conn);
?>

<html>


<?php include '../templates/header_faculty.php'; ?>


<body>

    <div class="wrapper mx-auto bg-slate-900 " style="color: #CAF0F8">

        <h1 class="text-xl md:text-3xl font-bold">Assigned Project</h1>
        <div class="overflow-x-auto text-black transition mt-1 darkb rounded-xl">
            <div class="table p-4">
                <!-- head -->
                <div class="text-white flex-col gap-4">
                    <!-- row 1 -->
                    <?php
                    foreach ($project as $projects) {
                        $status = $projects['approved'] ?? 2;
                    ?>
                        <div class="flex center-j-i text-lg">
                            <label class="label">
                                Project Name:
                            </label>
                            <p class="font-bold">
                                <?php echo $projects['name']; ?>
                            </p>
                        </div>
                        <hr />
                        <div class="flex flex-col center-j-i text-lg">
                            <label class="label">
                                Project Description:
                            </label>
                            <p class="font-bold  p-1">
                                <?php echo $projects['description']; ?>
                            </p>
                        </div>
                        <hr />
                        <div class="flex center-j-i text-lg">
                            <label class="label">
                                Project Status:
                            </label>
                            <p class="font-bold">
                                <?php echo $status == 1 ? '<span class="badge badge-outline badge-success">Approved</span>' : ($status == 0 ? '<span class="badge badge-outline badge-error">Rejected</span>' : '<span class="badge badge-outline badge-warning">Not Reviewed</span>'); ?>
                            </p>
                        </div>
                        <hr />

                        <div class="flex flex-col center-j-i text-lg">
                            <label class="label">
                                Project Action:
                            </label>
                            <p class="font-bold">
                                <a href="update_projects.php?projectid=<?php echo $projects['id']; ?>&action=a" class="btn btn-success"><i class="fa-solid fa-check"></i>Approve</a>
                                <a href="update_projects.php?projectid=<?php echo $projects['id']; ?>&action=r" class="btn btn-error"><i class="fa-solid fa-xmark"></i>Reject</a>
                            </p>
                        </div>
                        <td>
                            <form action="update_projects.php" method="post" class="flex gap-4 center-j-i mt-3">
                                <input type="hidden" name="projectid" value="<?php echo $projects['id']; ?>">
                                <textarea name="remarks" cols="30" rows="10" class="input input-bordered input-info text-white" placeholder="Enter remarks"><?php echo $projects['remarks']; ?></textarea>
                                <button type="submit" class="btn btn-info"><i class="fa-sharp fa-solid fa-pen-to-square"></i>Update</button>
                            </form>
                        </td>
                        </tr>
                    <?php } ?>
                    <!-- row 2 -->

                </div>
                <!-- foot -->

            </div>
        </div>
    </div>


</body>

</html>