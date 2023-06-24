<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // get all data from team table
    $query = "SELECT t.team_id, GROUP_CONCAT(s.name SEPARATOR ', ') AS team_members
              FROM team AS t
              LEFT JOIN students AS s ON FIND_IN_SET(s.enrollmentno, t.en_no)
              GROUP BY t.team_id";
    $result = mysqli_query($conn, $query);
    $teams = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $total_teams = mysqli_num_rows($result);
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>

<html>

<?php include '../templates/header.php'; ?>

<body>
    <div class="wrapper mx-auto bg-slate-900 " style="color: #CAF0F8">

        <h1 class="text-xl md:text-3xl font-bold">View and Manage Teams</h1>
        <p>
            Total teams: <?php echo $total_teams; ?>
        </p>
        <div class="m-3"></div>
        <div class="overflow-x-auto text-black transition" style="width: 90vw; background: #CAF0F8">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <div class="flex m-2 justify-end">
                            <input type="text" placeholder="Team name to search" class="input input-bordered input-info " oninput="search(this.value)" />
                        </div>
                    </tr>
                    <tr class="text-black">
                        <th>Team ID</th>
                        <th>Team Members</th>
                        <th>Team Size</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    <!-- rows -->
                    <?php
                    foreach ($teams as $team) {
                        $teamID = $team['team_id'];
                        $teamMembers = $team['team_members'];
                    ?>
                        <tr>
                            <td >
                                <?php echo $teamID; ?>
                            </td>
                            <td>
                                <?php echo $teamMembers; ?>
                            </td>
                            <td>
                                <?php echo substr_count($teamMembers, ',') + 1; ?>
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

        function confirmDelete(delUrl) {
            if (confirm("Are you sure you want to delete?")) {
                document.location = delUrl;
            }
        }

        function checkall() {
            const allcheckBoxes = document.querySelectorAll('input[type="checkbox"]');
            const firstBox = allcheckBoxes[0];
            // after 1 index
            Array(allcheckBoxes).shift();
            allcheckBoxes.forEach((checkbox) => {
                checkbox.checked = firstBox.checked;
            })
            toggleButtons(firstBox);
        }

        function toggleButtons(checkbox) {
            const editButtons = document.querySelectorAll('.edit-button');
            const deleteButtons = document.querySelectorAll('.delete-button');

            if (checkbox.checked) {
                enableButtons(editButtons);
                enableButtons(deleteButtons);
            } else {
                disableButtons(editButtons);
                disableButtons(deleteButtons);
            }
        }

        function enableButtons(buttons) {
            buttons.forEach((button) => {
                button.removeAttribute('disabled');
            });
        }

        function disableButtons(buttons) {
            buttons.forEach((button) => {
                button.setAttribute('disabled', 'disabled');
            });
        }
    </script>
</body>

</html>