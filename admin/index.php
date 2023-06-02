<?php
// Start session
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Get logged in admin's username from session
$username = $_SESSION['username'];
include_once("../templates/header.php");
?>
<div class="bg-container"></div>
<div class="AdminWrapper">
    <h1>Admin Dashboard</h1>
    <p>
        <span class="text-white text-xl md:text-3xl font-bold">
            Hello, <span class="text-indigo-700">
                <?php echo strtoupper($username); ?>
            </span> Welcome to Dashboard.
        </span><br>
        You can manage everything from here.
    </p>
</div>

</body>

</html>