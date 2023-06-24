<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // get all data from  faculty table
    $query = "SELECT * FROM faculty";
    $result = mysqli_query($conn, $query);
    $faculty = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $total_faculty = mysqli_num_rows($result);
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>

<html>


<?php include '../templates/header.php'; ?>


<body>

    <div class="wrapper mx-auto bg-slate-900 " style="color: #CAF0F8">

        <h1 class="text-xl md:text-3xl font-bold">View and Manage Faculty</h1>
        <p>
            Total faculty: <?php echo $total_faculty; ?>
        </p>
        <div class="m-3">

        </div>
        <div class="overflow-x-auto text-black transition" style="width: 90vw; background: #CAF0F8">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <div class="flex m-2 justify-end">
                            <input type="text" placeholder="Enter name to search" class="input input-bordered input-info " oninput="search(this.value)" />
                        </div>
                    </tr>
                    <tr class="text-black">
                        <th class="round-top">
                            <label>
                                <input type="checkbox" class="checkbox checkbox-info" onchange="checkall();" />
                            </label>
                        </th>
                        <th>Name</th>

                        <th>Email</th>
                        <th>
                            <a href="javascript:confirmDelete('deletefaculty.php?email=all')" class="btn btn-danger delete-button" disabled='true'>
                                <i class="fa-solid fa-trash"></i> Delete All
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    <!-- row 1 -->
                    <?php
                    foreach ($faculty as $facultys) { ?>
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" class="checkbox checkbox-info" onchange="toggleButtons(this)" />
                                </label>
                            </th>
                            <td>
                                <?php echo $facultys['name']; ?>

                            </td>

                            <td>
                                <?php echo $facultys['email']; ?>
                            </td>
                            <th>
                                <a href="editfaculty.php?email=<?php echo $facultys['email']; ?>" class="btn btn-primary btn-circle edit-button" disabled='true'>
                                    <i class="fa-solid fa-user-pen"></i>
                                </a>
                                <a href="javascript:confirmDelete('deletefaculty.php?email=<?php echo $facultys['email']; ?>')" class="btn btn-danger btn-circle delete-button" disabled='true'>
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </th>
                        </tr>
                    <?php } ?>
                    <!-- row 2 -->

                </tbody>
                <!-- foot -->


            </table>
        </div>
    </div>

    <script>
        // search function
        function search(value) {
            // javascript to search from table of html name
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach((row) => {
                const name = row.querySelector('td:nth-child(2)').innerText.toLowerCase();
                if (name.includes(value.toLowerCase())) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });

        }

        function confirmDelete(delUrl) {
            if (confirm("Are you sure you want to delete")) {
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
            ToggleButton(firstBox);
        }

        function ToggleButton(checkbox) {
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


        function toggleButtons(checkbox) {
            const editButton = checkbox.closest('tr').querySelector('.edit-button');
            const deleteButton = checkbox.closest('tr').querySelector('.delete-button');
            if (checkbox.checked) {
                editButton.removeAttribute('disabled');
                deleteButton.removeAttribute('disabled');
            } else {
                editButton.setAttribute('disabled', 'disabled');
                deleteButton.setAttribute('disabled', 'disabled');
            }
        }
    </script>
</body>

</html>