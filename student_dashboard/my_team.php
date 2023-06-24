<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/checkstudent.php";

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: /diaryproject/login.php");
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM students WHERE email = '$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$enrollment = $user['enrollmentno'];

// Fetch team details for the user's enrollment
$query = "SELECT * FROM team WHERE en_no LIKE '%$enrollment%'";
$result = mysqli_query($conn, $query);
$team = mysqli_fetch_assoc($result);

// Fetch team members based on the team's enrollments
$enrollments = explode(',', $team['en_no']);
$query = "SELECT * FROM students WHERE enrollmentno IN ('" . implode("','", $enrollments) . "')";
$result = mysqli_query($conn, $query);
$teamMembers = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<html>
<?php include '../templates/header_students.php'; ?>

<body>
    <div class="wrapper mx-auto bg-slate-900">
        <div class="flex center-j-i flex-col lightb gap-4 text-center rounded-xl p-5">
            <h1 class="text-xl md:text-3xl font-bold">My Team</h1>
            <?php if ($team) : ?>
                <?php if ($enrollments[0] == $enrollment) : ?>
                    <h3 class="text-lg font-bold">You are the team leader.</h3>
                <?php else : ?>
                    <h3 class="text-lg font-bold">You are a team member.</h3>
                <?php endif; ?>

                <table class="table">
                    <thead>
                        <tr class="text-black">
                            <th>Name</th>
                            <th>Enrollment</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teamMembers as $member) : ?>
                            <tr>
                                <td><?php echo $member['name']; ?></td>
                                <td><?php echo $member['enrollmentno']; ?></td>
                                <td><?php echo $member['email']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    <?php else : ?>
        <h3 class="text-lg font-bold">You are not a member of any team.</h3>
    <?php endif; ?>
    </div>
</body>

</html>