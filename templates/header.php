<head>
    <title><?php echo isset($title) ? $title : "ProjectDiary Mangement" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@2.6.0/dist/full.css" rel="stylesheet"  />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/79101233a3.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='index.css'>
    <link rel='stylesheet' href='utils.css'>
    <header style="  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;">
        <div class="navbar bg-base-100">
            <div class="flex-1">
                <a class="btn btn-ghost normal-case text-xl">Admin Panel</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    <li tabindex="0">
                        <a>
                            Add New
                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
                            </svg>
                        </a>
                        <ul class="p-2 bg-base-100">
                            <li><a href="register.php">Students </a></li>
                            <li><a>Faculties</a></li>
                        </ul>
                    </li>
                    <li tabindex="0">
                        <a>
                            Teams
                            <svg class="fill-current" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z" />
                            </svg>
                        </a>
                        <ul class="p-2 bg-base-100">
                            <li><a>View </a></li>
                            <li><a>Assign</a></li>
                        </ul>
                    </li>
                    <li><a>Projects</a></li>
                </ul>
                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <div class="icon flex items-center  justify-center w-100 text-lg" style="height: 100%">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                    </label>
                    <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
                        <li>
                            <a class="justify-between">
                                Change Password

                            </a>
                        </li>
                        <li><a>Change Username</a></li>
                        <li><a>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

    </header>
</head>