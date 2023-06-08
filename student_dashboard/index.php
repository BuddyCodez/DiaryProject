<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/diaryproject/api/checkstudent.php";

?>
<html>
<?php include '../templates/header_students.php'; ?>

<body>
    <div class="wrapper bg-slate-900 ">
        <div>
            <span>
                Welcome
                <h1 class="text-center text-4xl text-info"><?php echo $_SESSION['username'] ?><span></span></h1>
                to your dashboard
            </span>
        </div>
    </div>
</body>

</html>