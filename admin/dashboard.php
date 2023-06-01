<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daisyui@1.13.1/dist/full.css">
    <link rel="stylesheet" href="../css/index.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <!-- Header -->
    <nav class="bg-primary-500">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center justify-between">
                <div>
                    <a href="#" class="text-white text-lg font-semibold">Admin Panel</a>
                </div>
                <div class="hidden md:block">
                    <ul class="flex space-x-4">
                        <li>
                            <a href="#" class="text-white hover:text-primary-200">Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="text-white hover:text-primary-200">Users</a>
                        </li>
                        <li>
                            <a href="#" class="text-white hover:text-primary-200">Settings</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <button class="bg-white text-primary-500 rounded-md px-4 py-2 font-semibold hover:bg-primary-200">
                        Logout
                    </button>
                </div>
                <div class="md:hidden">
                    <button class="text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
        <p>Welcome to the admin dashboard. You can manage various aspects of your application here.</p>
        <!-- Add your dashboard content here -->
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.0/dist/alpine.min.js"></script>
</body>

</html>