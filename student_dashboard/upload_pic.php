<?php
session_start();
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
if (isset($_SESSION["isloggedin"]) && $_SESSION["isloggedin"] == true) {
    header("location: ../login.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $uploadDir = 'C:\xampp\htdocs\DiaryProject\templates\uploads\\';

    // Get the uploaded file information
    $fileName = $_FILES['picture']['name'];
    $fileTmpName = $_FILES['picture']['tmp_name'];
    $fileSize = $_FILES['picture']['size'];
    $fileError = $_FILES['picture']['error'];
    $fileType = $_FILES['picture']['type'];
    $userName = $_SESSION['username'];
    $email = $_SESSION['email'];
    $newFileName = $userName . '.png';

    // Move the uploaded file to the desired destination with the new file name
    $destination = $uploadDir . $newFileName;
    $query = "UPDATE `students` SET `profile_pic_path` = '$newFileName' WHERE `email` = '$email'";
    // Check if file was uploaded without any errors
    $allowedImageTypes = array('image/jpeg', 'image/jpg', 'image/webp', 'image/png', 'image/gif');
    if (in_array($fileType, $allowedImageTypes) && strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) != 'md') {
        if (move_uploaded_file($fileTmpName, $destination)) {
            $message = 'File uploaded successfully.';
            $type = 'success';
        } else {
            $type = 'danger';
            $message = 'Error uploading file.';
        }
    } else {
        $message = 'Invalid file type. Please upload an image file (JPEG, JPG, WEBP, PNG, GIF) without .md extension.';
        $type = 'danger';
    }
}

?>

<html>


<?php include '../templates/header_students.php'; ?>


<body>

    <div class="wrapper mx-auto py-1 md:p-7 bg-slate-900 ">

        <h1 class="text-xl md:text-3xl font-bold mb-5 mything">Upload Profile Picture</h1>

        <form action="upload_pic.php" method="POST" enctype="multipart/form-data">
            <?php
            if (isset($message)) echo $type == "danger" ? "<div class='alert alert-error shadow-lg show'><div>
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
                <label class="block font-bold mb-2" for="name">Upload Picture</label>
                <input class="border border-gray-300 px-4 py-2 w-full" type="file" name="picture" required>
            </div>

            <div class="mb-4">
                <button class="btn btn-info text-black" type="submit">Upload</button>
            </div>
        </form>
    </div>

</body>

</html>