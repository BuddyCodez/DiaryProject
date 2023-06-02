<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/connection.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Path to the .env file
    $envFilePath = realpath($_SERVER["DOCUMENT_ROOT"]) . '/dairyproject/.env';

    // Read the contents of the .env file
    $envFile = file_get_contents($envFilePath);
    $lines = explode("\n", $envFile);

    $env = [];

    foreach ($lines as $line) {
        $parts = explode('=', $line, 2);

        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);

            $env[$key] = $value;
        }
    }
    $envArray = $env;
    // print_r($envArray);
    $uname = $envArray['DB_USERNAME'];
    $upass = $envArray['DB_PASSWORD'];

    // Check if the CSV file is uploaded and valid
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == $uname && $password == $upass) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = "admin";
        header("location: ../admin/index.php");
        exit;
    } else {
        $message = "Invalid username or password";
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="../css/index.css">
    <title><?php echo isset($title) ? $title : "ProjectDiary Mangement" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/79101233a3.js" crossorigin="anonymous"></script>
</head>



<body>

    <div class="wrapper mx-auto py-1 md:p-7 bg-slate-900 max-h-screen flex items-center flex-col justify-center gap-4" style="width:100%;height:100%;">

        <h1 class="text-xl md:text-3xl font-bold mb-5" align="center">Admin Login</h1>

        <form action="login.php" method="POST" enctype="multipart/form-data" class="flex items-center flex-col justify-center gap-2">
            <?php

            $svg = isset($message) && $message == "Invalid username or password" ?  " <svg xmlns='http://www.w3.org/2000/svg' class='stroke-current flex-shrink-0 h-6 w-6' fill='none' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' /></svg>
" : "<svg xmlns='http://www.w3.org/2000/svg' class='stroke-current flex-shrink-0 h-6 w-6' fill='none' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                    </svg>";
            $color = isset($message) && $message == "Invalid username or password" ?  "alert-error" : "alert-success";
            if (isset($message)) echo "<div class='alert $color shadow-lg'><div>$svg
                    <span>$message</span>
                </div>
            </div>";
            ?>
            <div class="mb-4">
                <label class="block font-bold mb-2" for="username">Username</label>
                <input class="border border-gray-300 px-4 py-2 w-full rounded-lg text-black" type="text" name="username" required>
            </div>
            <div class="mb-4">
                <label class="block font-bold mb-2" for="password">Password</label>
                <input class="border border-gray-300 px-4 py-2 w-full rounded-lg text-black" type="password" name="password" required>
            </div>

            <div class="mb-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Login</button>
            </div>
        </form>
    </div>


</body>

</html>