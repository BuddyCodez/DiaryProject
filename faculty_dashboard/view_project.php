<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/checkfaculty.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // get all data from  students table
    $query = "SELECT * FROM project";
    $result = mysqli_query($conn, $query);
    $project = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $total_project = mysqli_num_rows($result);
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>

<html>


<?php include '../templates/header_faculty.php'; ?>


<body>

    <div class="wrapper mx-auto bg-slate-900 " style="color: #CAF0F8">

        <h1 class="text-xl md:text-3xl font-bold">View Projects</h1>
        <p>
            Total Project: <?php echo $total_project; ?>
        </p>
        <div class="m-3">

        </div>
        <div class="overflow-x-auto text-black transition" style="width: 90vw; background: #CAF0F8">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <div class="flex m-2 justify-end">
                            <input type="text" placeholder="Enter name to search" class="input input-bordered input-info text-white " oninput="search(this.value)" />
                        </div>
                    </tr>
                    <tr class="text-black">
                        <th>name</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    <!-- row 1 -->
                    <?php
                    foreach ($project as $projects) { 
                        $status = $projects['approved'] ?? 2;
                        ?>
                        <tr>

                            <td>
                                <?php echo $projects['name']; ?>

                            </td>
                            <td>
                                <?php echo $projects['description']; ?>
                            </td>
                            <td>
                                <?php echo $status == 1 ? 'Approved' : ($status == 0 ? 'Rejected' : 'Not Reviewed') ; ?>
                            </td>
                            <td>
                                <a href="update_projects.php?projectid=<?php echo $projects['id']; ?>&action=a" class="btn btn-success"><i class="fa-solid fa-check"></i>Approve</a>
                                <a href="update_projects.php?projectid=<?php echo $projects['id']; ?>&action=r" class="btn btn-error"><i class="fa-solid fa-xmark"></i>Reject</a>
                            </td>

                        </tr>
                    <?php } ?>
                    <!-- row 2 -->

                </tbody>
                <!-- foot -->

            </table>
        </div>
    </div>


</body>

</html>