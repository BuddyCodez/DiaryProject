<?php
// Check if the form is submitted
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new username from the form
    $newUsername = $_POST['username'];

    // Read the contents of the .env file
    $envFilePath = 'C:\xampp\htdocs\diaryproject\.env';

    // Read the contents of the .env file
    $envFile = file_get_contents($envFilePath);
    // Replace the existing admin username with the new one
    $envFile = preg_replace('/^DB_USERNAME=.*$/m', "DB_USERNAME={$newUsername}", $envFile);

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
        <h1 class="text-xl md:text-3xl font-bold">Change Admin Username</h1>

        <form method="post" action="change_username.php" class="flex flex-col gap-2">
            <label for="username">New Username:</label>
            <input type="text" name="username" id="username" required>

            <button type="submit" class="btn btn-info">Change Username</button>
        </form>
    </div>
</body>

</html>