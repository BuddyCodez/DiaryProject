<?php
// Check if the form is submitted
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/admincheck.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new username from the form
    $newPassword = $_POST['password'];

    // Read the contents of the .env file
    $envFilePath = 'C:\xampp\htdocs\DairyProject\.env';

    // Read the contents of the .env file
    $envFile = file_get_contents($envFilePath);
    // Replace the existing admin username with the new one
    $envFile = preg_replace('/^DB_PASSWORD=.*$/m', "DB_PASSWORD={$newPassword}", $envFile);

    // Write the updated contents back to the .env file
    file_put_contents($envFilePath, $envFile);
    session_destroy();
    // Redirect to a success page or perform any other actions
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Change Admin Username</title>
</head>
<?php include '../templates/header.php'; ?>

<body>
    <div class="wrapper mx-auto  md:p-7 bg-slate-900">
        <h1 class="text-xl md:text-3xl font-bold">Change Admin Password</h1>

        <form method="post" action="change_password.php" class="flex flex-col gap-2">
            <label for="password">New Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="btn btn-info">Change Password</button>
        </form>
    </div>
</body>

</html>