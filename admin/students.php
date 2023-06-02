<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/admincheck.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // get all data from  students table
    $query = "SELECT * FROM students";
    $result = mysqli_query($conn, $query);
    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $total_students = mysqli_num_rows($result);
    mysqli_free_result($result);
    mysqli_close($conn);
}
?>

<html>


<?php include '../templates/header.php'; ?>


<body>

    <div class="wrapper mx-auto  md:p-7 bg-slate-900">

        <h1 class="text-xl md:text-3xl font-bold">View and Manage Students</h1>
        <p>
            Total Students: <?php echo $total_students; ?>
        </p>
        <div class="overflow-x-auto bg-indigo-900" style="width: 90vw;">
            <table class="table">
                <!-- head -->
                <thead>
                    <tr>
                        <th class="round-top">
                            <label>
                                <input type="checkbox" class="checkbox" onchange="checkall();" />
                            </label>
                        </th>
                        <th>Name</th>
                        <th>Enrollment No</th>
                        <th>Email</th>
                        <th class="round-top"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- row 1 -->
                    <?php
                    foreach ($students as $student) { ?>
                        <tr>
                            <th>
                                <label>
                                    <input type="checkbox" class="checkbox" onchange="toggleButtons(this)" />
                                </label>
                            </th>
                            <td>
                                <?php echo $student['name']; ?>

                            </td>
                            <td>
                                <?php echo $student['enrollmentno']; ?>
                            </td>
                            <td>
                                <?php echo $student['email']; ?>
                            </td>
                            <th>
                                <a href="editstudent.php?id=<?php echo $student['id']; ?>" class="btn btn-primary edit-button" disabled='true'>Edit</a>
                                <a href="deletestudent.php?id=<?php echo $student['id']; ?>" class="btn btn-danger delete-button" disabled='true'>Delete</a>
                            </th>
                        </tr>
                    <?php } ?>
                    <!-- row 2 -->

                </tbody>
                <!-- foot -->
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Enrollment No</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

    <script>
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