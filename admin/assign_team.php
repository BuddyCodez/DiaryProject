<?php
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";

$msg = $type = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $squery = mysqli_query($conn, "SELECT * FROM `students`");
    $query = mysqli_query($conn, "SELECT faculty_id FROM `team_project`");
    $fquery = mysqli_query($conn, "SELECT * FROM `faculty`");
    $teamq = mysqli_query($conn, "SELECT en_no FROM `team`");

    $addedStudents = array();
    while ($r = mysqli_fetch_assoc($teamq)) {
        $arr = explode(",", $r['en_no']);
        $addedStudents = array_merge($addedStudents, $arr);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $users = $_POST["user_ids"];
        $faculty = $_POST['faculty'];
        if (!isset($_POST['user_ids']) && empty($_POST['user_ids']) || empty($_POST['faculty'])) {
            $msg = "Please select at least one student and a faculty";
            $type = "error";
            header("Location: assign_team.php?msg=" . urlencode($msg) . "&type=" . urlencode($type));
        } else {
            $team_len = count($users);
            $enrollments = implode(",", $users);

            $validationq = "SELECT en_no FROM team WHERE en_no = '$enrollments'";
            $validres = mysqli_query($conn, $validationq);

            if ($validres->num_rows == 0) {
                $result = mysqli_query($conn, "INSERT INTO team(team_length, en_no) VALUES ('$team_len', '$enrollments')");
                $r = mysqli_query($conn, "SELECT * FROM team WHERE en_no = '$enrollments'");
                $resarr = $r->fetch_array();
                $tid = $resarr['team_id'];
                $res = mysqli_query($conn, "INSERT INTO team_project(team_id, faculty_id) VALUES ('$tid', '$faculty')");
                $msg = "Successfully created";
                $type = "success";
            } else {
                $msg = "Team with the same enrollment already exists";
                $type = "error";
                header("Location: assign_team.php?msg=" . urlencode($msg) . "&type=" . urlencode($type));
            }
            header("Location: assign_team.php");
        }
    } catch (Exception $e) {
        $msg = "Error: " . $e->getMessage();
        $type = "error";
        header("Location: assign_team.php?msg=" . urlencode($msg) . "&type=" . urlencode($type));
    }

    // exit;
}
?>

<html>
<?php include '../templates/header.php'; ?>

<body>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
        }

        .bg {
            background-color: #03045E;
            padding: 10px;
        }

        .input-group {
            justify-content: center;
        }
    </style>
    <div class="wrapper mx-auto bg-slate-900 text-center">
        <h1 class="text-xl md:text-3xl font-bold">Assign Team</h1>
        <form action="assign_team.php" method="POST" class="flex flex-col center-j-i gap-3">
            <?php if (isset($_GET['msg'])) : ?>
                <div class="alert alert-<?php echo $_GET['type']; ?> shadow-lg">
                    <div>
                        <?php if (isset($_GET['type']) && $_GET['type'] === "error") : ?>
                            <i class="fa-solid fa-circle-xmark"></i>
                        <?php elseif ($_GET['type'] === "success") : ?>
                            <i class="fa-solid fa-circle-check"></i>
                        <?php endif; ?>
                        <span><?php echo $_GET['msg']; ?></span>
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-control">
                <label class="label">
                    <label for="user_list">Select Users (up to 5):</label>
                </label>
                <label class="input-group">
                    <div class="user-list" id="user_list">
                        <?php
                        while ($row = mysqli_fetch_assoc($squery)) {
                            if (in_array($row['enrollmentno'], $addedStudents)) {
                                continue; // Skip this student
                            }
                            echo '<label class="flex center-i-j gap-2"><input type="checkbox" class="checkbox" name="user_ids[]" value="' . $row['enrollmentno'] . '" onclick="selectUser()"><h3>' . $row['name'] . '</h3></label>';
                        }
                        ?>
                    </div>
                </label>
            </div>
            <div class="form-control">
                <div class="input-group">
                    <select name="faculty" class="select w-full max-w-xs" required>
                        <option class="text-white" disabled selected>Select Faculty</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($fquery)) {
                            if (mysqli_fetch_row($query) > 0) {
                                while ($r2 = mysqli_fetch_assoc($query)) {
                                    if ($row['id'] == $r2['faculty_id']) {
                                        continue;
                                    }
                                    echo '<option value="' . $row['id'] . '" class="text-white">' . $row['name'] . '</option>';
                                }
                            } else {
                                echo '<option value="' . $row['id'] . '" class="text-white">' . $row['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <button class="btn btn-accent" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function selectUser() {
            var userList = document.getElementById('user_list');
            var selectedUsers = document.querySelectorAll('#user_list input:checked');
            if (selectedUsers.length > 5) {
                alert('You can select up to 5 users only.');
                selectedUsers[selectedUsers.length - 1].checked = false;
            }
        }
    </script>
</body>

</html>