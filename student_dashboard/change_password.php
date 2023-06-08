<?php
session_start();
// Check if the form is submitted
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new username from the form
    $pass = $_POST['password'];
    $email = $_SESSION['email'];
    $query = "UPDATE students SET password = '$pass' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if ($result) {
       
        $type = "success";
        $message = "Password Changed Successfully";
    } else {
        $type = "danger";
        $message = "Password Change Failed!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Change Admin Username</title>
</head>
<?php include '../templates/header_students.php'; ?>


<body>
    <div class="wrapper mx-auto  md:p-7 bg-slate-900">
        <h1 class="text-xl md:text-3xl font-bold">Change Your Password</h1>
        <form method="post" action="change_password.php" class="flex flex-col gap-2">
            <?php
            if (isset($message)) {
                echo $type == "danger" ? "<div class='alert alert-error shadow-lg transition'><div>
           <i class='fa-solid fa-circle-xmark'></i>
                    $message</span>
                </div>
            </div>" : "<div class='alert alert-success shadow-lg'><div>
            <i class='fa-solid fa-circle-check'></i>
                    $message</span>
                </div>
            </div>";
                echo "<script>
            setTimeout(() => {
                document.querySelector('.alert').remove();
            }, 2000);
            </script>";
            }
            ?>
            <label for="password">New Passowrd:</label>
            <input type="password" name="password" id="password" class="input"  required>

            <button type="submit" class="btn btn-info">Change Password</button>
        </form>
    </div>
</body>

</html>