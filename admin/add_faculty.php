<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/admincheck.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if the CSV file is uploaded and valid
    $type = $_POST['type'];
    if ($type == "multiple") {
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $csvFilePath = $_FILES['csv_file']['tmp_name'];

            // Read the CSV file
            $file = fopen($csvFilePath, 'r');
            if ($file !== false) {
                // Database connection

                if ($conn !== false) {
                    // Prepare the insert statement
                    // random id for each faculty
                    $id = rand(100000, 999999);
                    // check if id exists in db
                    $query = "SELECT * FROM faculty WHERE id = '$id'";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        $id = rand(100000, 999999);
                    }
                    $query = "INSERT INTO faculty (id,name,  branch_id, email, password) VALUES (?,?, ?, ?, ?, ?)";
                    $statement = mysqli_prepare($conn, $query);

                    // Bind parameters to the statement
                    mysqli_stmt_bind_param($statement, 'ssiss', $id,$name, $branch_id, $email, $hashedPassword);

                    try {
                        $data = fgetcsv($file);
                        while (
                            $data !== false
                        ) {
                            // Extract data from CSV columns
                            $id = $data[0];
                            $name = $data[1];

                            $branch_id = $data[2];
                            $email = $data[3];
                            $password = $data[4];

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
                        $message =  "Added Faculty successfully!";
                    } catch (Exception $e) {

                        $type = "danger";
                        $message =  "Cannot Add Faculty Code Stack:\n" . $e->getMessage();
                        if ($e->getCode() == 1062) {
                            $message = "Duplicate Entry for Email : <br> $email ";
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
    } else {
        $name = $_POST['name'];
        $branch_id = $_POST['branch'];
        $email = $_POST['email'];
        $password = $_POST['pass'];
        $id = rand(100000, 999999);
        $query = "SELECT * FROM faculty WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) > 0){
            $id = rand(100000, 999999);
        }
        $query = "INSERT INTO faculty (id,name, branch_id, email, password) VALUES ('$id','$name',  '$branch_id', '$email', '$password')";
        try {
            $result = mysqli_query($conn, $query);
            if ($result) {
                $type = "success";
                $message =  "Added Faculty successfully!";
            }
        } catch (Exception $e) {
            $type = "danger";
            $message =  "Cannot Add Faculty Code Stack:\n" . $e->getMessage();
            if ($e->getCode() == 1062) {
                $message = "Duplicate Entry for Email: <br> $email ";
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM branches";
    $result = mysqli_query($conn, $query);
    $branches = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<html>


<?php include '../templates/header.php'; ?>


<body>

    <div class="wrapper mx-auto md:p-7 bg-slate-900">

        <h1 class="text-xl md:text-3xl font-bold mb-5 mything">Add Faculty</h1>
        <div class="flex">
            <div class="join join-vertical w-full">
                <div class="collapse collapse-arrow join-item border border-base-300">
                    <input type="radio" name="my-accordion-4" checked="checked" />
                    <div class="collapse-title text-xl font-medium">
                        Bulk Add Faculty
                    </div>
                    <div class="collapse-content">
                        <form action="add_faculty.php" method="POST" enctype="multipart/form-data">
                            <?php
                            if (isset($message)) echo $type == "danger" ? "<div class='alert alert-error shadow-lg'><div>
           <i class='fa-solid fa-circle-xmark'></i>
                    $message</span>
                </div>
            </div>" : "<div class='alert alert-success shadow-lg'><div>
            <i class='fa-solid fa-circle-check'></i>
                    $message</span>
                </div>
            </div>";
                            ?>
                            <div class="mb-4">
                                <label class="block font-bold mb-2" for="name">Upload Csv File</label>
                                <input class="border border-gray-300 px-4 py-2 w-full" type="file" name="csv_file" required>
                            </div>
                            <input type="hidden" value="multiple" name="type">

                            <div class="mb-4">
                                <button class="btn btn-info text-black" type="submit">Add Faculty</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="collapse collapse-arrow join-item border border-base-300">
                    <input type="radio" name="my-accordion-4" />
                    <div class="collapse-title text-xl font-medium">
                        Add Faculty
                    </div>
                    <div class="collapse-content">
                        <form action="add_faculty.php" method="POST" enctype="multipart/form-data">
                            <?php
                            if (isset($message)) echo $type == "danger" ? "<div class='alert alert-error shadow-lg'><div>
           <i class='fa-solid fa-circle-xmark'></i>
                    $message</span>
                </div>
            </div>" : "<div class='alert alert-success shadow-lg'><div>
            <i class='fa-solid fa-circle-check'></i>
                    $message</span>
                </div>
            </div>";
                            ?>
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Enter Your Name:</span>
                                </label>
                                <input name="name" type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" required />
                            </div>
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Enter Your Email:</span>
                                </label>
                                <input type="email" name="email" placeholder="Type here" class="input input-bordered w-full max-w-xs" required />
                            </div>
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Enter Your Password:</span>
                                </label>
                                <input type="password" name="pass" placeholder="Type here" class="input input-bordered w-full max-w-xs" required />
                            </div>
                            <div class="form-control w-full max-w-xs">
                                <label class="label">
                                    <span class="label-text">Select Branch:</span>
                                </label>
                                <select class="select w-full max-w-xs text-white" name="branch">
                                    <?php foreach ($branches as $branch) { ?>
                                        <option value="<?php echo $branch['id'] ?>" style="color:white;">
                                            <?php echo $branch['branch_name'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <input type="hidden" value="single" name="type">
                                <div class="mt-4 form-control w-full max-w-xs">
                                    <button class="btn btn-info text-black" type="submit">Add Faculty</button>
                                </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>


</body>

</html>