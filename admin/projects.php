<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // get all data from team table
    $query = "SELECT * FROM project";
    $result = mysqli_query($conn, $query);
    $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $total_projects = mysqli_num_rows($result);
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>

<html>

<?php include '../templates/header.php'; ?>

<body>
    <div class="wrapper mx-auto bg-slate-900 gap-4" style="color: #CAF0F8">

        <h1 class="text-xl md:text-3xl font-bold">View Projects</h1>
        <p>
            Total teams: <?php echo $total_projects; ?>
        </p>
        <div class="overflow-x-auto text-black transition lightb rounded-lg">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr class="text-white">
                        <th>Project ID</th>
                        <th>Project Name</th>
                        <th>Project Status</th>
                        <th>Project Remarks</th>
                    </tr>
                </thead>
                <tbody class="text-white">
                    <!-- rows -->
                    <?php
                    foreach ($projects as $project) {
                        $projectId = $project['id'];
                    ?>
                        <tr>
                            <td>
                                <?php echo $projectId; ?>
                            </td>
                            <td>
                                <?php echo $project['name']; ?>
                            </td>
                            <td>
                                <?php echo $project['approved'] ?? 'Not Reviewed'; ?>
                            </td>
                            <td>
                                <?php echo $project['remarks'] ?? 'No Remarks'; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // search function
        function search(value) {
            // javascript to search from table of html name
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row) => {
                const teamID = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
                const teamMembers = row.querySelector('td:nth-child(3)').innerText.toLowerCase();
                if (teamID.includes(value.toLowerCase()) || teamMembers.includes(value.toLowerCase())) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>