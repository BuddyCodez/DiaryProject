<?php
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/connection.php";
include realpath($_SERVER["DOCUMENT_ROOT"]) . "/dairyproject/api/admincheck.php";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['id'])) {
        header("Location: /dairyproject/admin/students.php");
    } else {

        $id = $_GET['id'];
        $query = "SELECT * FROM students WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        // get all branches
        $query = "SELECT * FROM branches";
        $result = mysqli_query($conn, $query);
        $branches = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

?>

<html>


<?php include '../templates/header.php'; ?>

<body>

    <div class="wrapper mx-auto bg-slate-900">
        <h1 class="text-xl md:text-3xl font-bold">Edit <?php echo $row['name']; ?></h1>
        <form action="edit_action.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>"  required />
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Enter Your Name:</span>
                </label>
                <input name="name" type="text" placeholder="Type here" value="<?php echo $row['name']; ?>" class="input input-bordered w-full max-w-xs" required />
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Enter Your Email:</span>
                </label>
                <input type="email" name="email" placeholder="Type here" value="<?php echo $row['email']; ?>" class="input input-bordered w-full max-w-xs" required />
            </div>
            <div class="form-control w-full max-w-xs">
                <label class="label">
                    <span class="label-text">Enter Your Enrollment:</span>
                </label>
                <input type="number" name="enrollmentno" placeholder="Type here" value="<?php echo $row['enrollmentno']; ?>" class="input input-bordered w-full max-w-xs" required />
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
                <select class="select w-full max-w-xs text-white" id="MySelect" name="branch">
                    <?php foreach ($branches as $branch) { ?>
                        <option value="<?php echo $branch['id'] ?>" style="color:white;">
                            <?php echo $branch['branch_name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-control w-full max-w-xs">
                <button type="submit" class="btn btn-accent w-full max-w-xs mt-3">
                    submit
                </button>
            </div>
        </form>
    </div>
    <script>
        let BranchId = <?php echo $row['branch_id']; ?>;
        let selectElement = document.querySelector("#MySelect");
        var desiredValue = BranchId.toString(); // Replace '2' with the desired value
        // Find the index of the option with the desired value
        var selectedIndex = -1;
        for (var i = 0; i < selectElement.options.length; i++) {
            if (selectElement.options[i].value === desiredValue) {
                selectedIndex = i;
                break;
            }
        }
        selectElement.selectedIndex = selectedIndex;
    </script>

</body>

</html>