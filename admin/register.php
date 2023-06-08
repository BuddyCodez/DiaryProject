<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";


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
                        $hashedPassword = $password;

                        // Execute the statement to insert the data into the database table
                        mysqli_stmt_execute($statement);

                        // Read the next line
                        $data = fgetcsv($file);
                    }

                    // Close the statement and database conn
                    mysqli_stmt_close($statement);
                    mysqli_close($conn);
                    $type = "success";
                    $message =  "Added Students successfully!";
                } catch (Exception $e) {
                    
                    $type = "danger";
                    $message =  "Cannot Add Students Code Stack:\n" . $e->getMessage();
                    if($e->getCode() == 1062){
                        $message = "Duplicate Entry for Email or Enrollment Number: <br> $email or $enrollmentno";
                    }
                }
            } else {
                $message =  "Failed to connect to the database.";
                $type = "danger";
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
            if (isset($message)) echo $type == "danger" ? "<div class='alert alert-error shadow-lg'><div>
           <i class='fa-solid fa-circle-xmark'></i>
                    $message</span>
                </div>
            </div>": "<div class='alert alert-success shadow-lg'><div>
            <i class='fa-solid fa-circle-check'></i>
                    $message</span>
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