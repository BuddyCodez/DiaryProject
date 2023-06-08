<head>
    <title><?php echo isset($title) ? $title : "ProjectDiary Mangement" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.0.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/79101233a3.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="http://localhost/diaryproject/templates/css/index.css">
    <link rel='stylesheet' href='http://localhost/diaryproject/templates/css/utils.css'>
    <header style="  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;">
        <div class="navbar darkb pcNavbar">
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl">StudentPanel</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="http://localhost/diaryproject/student_dashboard">Home</a></li>
                    <li>
                        <details>
                            <summary>
                                View
                            </summary>
                            <ul class="p-2 bg-base-100">
                                <li><a href="students.php">Team </a></li>
                                <li><a>Project</a></li>
                            </ul>
                    </li>
                    <li>
                        <details>
                            <summary>
                                Add New
                            </summary>
                            <ul class="p-2 bg-base-100">
                                <li><a href="register.php">Daily Task</a></li>

                            </ul>
                        </details>
                    </li>
                </ul>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <div class="icon">

                                <?php
                                $username = $_SESSION['username'] ?? "";
                                //  "<i class='fas fa-user'></i>";
                                echo  "<img src='http://localhost/DiaryProject/templates/uploads/$username.png' alt='profile_pic' />"  ?>
                            </div>
                        </div>
                    </label>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a class="justify-between" href="upload_pic.php">Upload Picture<i class="fa-solid fa-image"></i></a></li>
                        <li>
                            <a class="justify-between" href="change_username.php">
                                Change Name<i class="fa-solid fa-signature"></i>

                            </a>
                        </li>

                        <li><a class="justify-between" href="change_password.php">Change Password<i class="fa-solid fa-lock"></i></a></li>
                        <li><a class="justify-between" href="logout.php">Logout <i class="fa-solid fa-right-from-bracket"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="navbar darkb mobileNavbar">
            <div class="navbar-start">
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </label>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="http://localhost/diaryproject/student_dashboard">Home</a></li>
                        <li>
                            <details>
                                <summary>
                                    View
                                </summary>
                                <ul class="p-2 bg-base-100">
                                    <li><a href="students.php">Team </a></li>
                                    <li><a>Project</a></li>
                                </ul>
                        </li>
                        <li>
                            <details>
                                <summary>
                                    Add New
                                </summary>
                                <ul class="p-2 bg-base-100">
                                    <li><a href="register.php">Daily Task</a></li>

                                </ul>
                            </details>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-center">
                <a class="btn btn-ghost normal-case text-xl">StudentPanel</a>
            </div>
            <div class="navbar-end">
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <div class="icon">

                                <?php
                                $username = $_SESSION['username'] ?? "";
                                //  "<i class='fas fa-user'></i>";
                                echo  "<img src='http://localhost/DiaryProject/templates/uploads/$username.png' alt='profile_pic' />"  ?>
                            </div>
                        </div>
                    </label>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a class="justify-between" href="upload_pic.php">Upload Picture<i class="fa-solid fa-image"></i></a></li>
                        <li>
                            <a class="justify-between" href="change_username.php">
                                Change Name<i class="fa-solid fa-signature"></i>

                            </a>
                        </li>

                        <li><a class="justify-between" href="change_password.php">Change Password<i class="fa-solid fa-lock"></i></a></li>
                        <li><a class="justify-between" href="logout.php">Logout <i class="fa-solid fa-right-from-bracket"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
</head>