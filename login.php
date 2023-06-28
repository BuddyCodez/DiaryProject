<html>

<head>
    <title><?php echo isset($title) ? $title : "ProjectDiary Mangement" ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.0.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/79101233a3.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="http://localhost/diaryproject/templates/css/index.css">
    <link rel='stylesheet' href='http://localhost/diaryproject/templates/css/utils.css'>
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-slate-900 text-black">
        <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg rounded-sm">
            <h3 class="text-2xl font-bold text-center">Login to your account</h3>
            <form action="login_action.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <?php if (isset($_GET['msg'])) { ?>
                    '<div class="alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo $_GET['msg']; ?></span>
                    </div>
                <?php } ?>
                <div class="mt-4">
                    <div>
                        <label class="block" for="email">Email<label>
                                <input autocomplete="off" type="text" placeholder="Email" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" name="email">
                    </div>
                    <div class="mt-4">
                        <label class="block">Password<label>
                                <input autocomplete="off" type="password" placeholder="Password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600" name="password">
                    </div>
                    <div class="flex items-baseline justify-between">
                        <button type="submit" class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900" value="Login">Login</button>
                        <a href="#" class="text-sm text-blue-600 hover:underline">Forgot password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>