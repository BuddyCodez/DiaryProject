<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/admincheck.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if the CSV file is uploaded and valid
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $csvFilePath = $_FILES['csv_file']['tmp_name'];

        // Read the CSV file
        $file = fopen($csvFilePath, 'r');
        if ($file !== false) {
            // Database connection

            if ($conn !== false) {
                // Prepare the insert statement
                $query = "INSERT INTO students (name, enrollmentno, branch_id, email, password) VALUES (?, ?, ?, ?, ?)";
                $statement = mysqli_prepare($conn, $query);

                // Bind parameters to the statement
                mysqli_stmt_bind_param($statement, 'ssiss', $name, $enrollmentno, $branch_id, $email, $hashedPassword);

                try {
                    $data = fgetcsv($file);
                    while (
                        $data !== false
                    ) {
                        // Extract data from CSV columns
                        $id = $data[0];
                        $name = $data[1];
                        $enrollmentno = $data[2];
                        $branch_id = $data[3];
                        $email = $data[4];
                        $password = $data[5];

                        // Hash the password using password_hash()
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                        // Execute the statement to insert the data into the database table
                        mysqli_stmt_execute($statement);

                        // Read the next line
                        $data = fgetcsv($file);
                    }

                    // Close the statement and database conn
                    mysqli_stmt_close($statement);
                    mysqli_close($conn);
                    $message =  "Added Students successfully!";
                } catch (Exception $e) {
                    $message =  "Cannot Add Students Code Stack:\n" . $e->getMessage();
                }
            } else {
                $message =  "Failed to connect to the database.";
            }

            // Close the CSV file
            fclose($file);
        }
    }
}
?>

<html>


<?php include '../templates/header.php'; ?>


<body>

    <div class="wrapper mx-auto py-1 md:p-7 bg-slate-900">

        <h1 class="text-xl md:text-3xl font-bold mb-5 mything">Add Students</h1>

        <form action="register.php" method="POST" enctype="multipart/form-data">
            <?php
            if (isset($message)) echo "<div class='alert alert-success shadow-lg'><div><svg xmlns='http://www.w3.org/2000/svg' class='stroke-current flex-shrink-0 h-6 w-6' fill='none' viewBox='0 0 24 24'>
                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' />
                    </svg>
                    <span>$message</span>
                </div>
            </div>";
            ?>
            <div class="mb-4">
                <label class="block font-bold mb-2" for="name">Upload Csv File</label>
                <input class="border border-gray-300 px-4 py-2 w-full" type="file" name="csv_file" required>
            </div>

            <div class="mb-4">
                <button class="btn btn-info text-black" type="submit">Add students</button>
            </div>
        </form>
    </div>


</body>

</html>