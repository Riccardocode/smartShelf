<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Shelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-indigo-800 py-4 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="flex justify-center gap-10 lg:w-0 lg:flex-1">
                    <a href="#" class="text-2xl font-bold text-white">SmartShelf</a>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <a href="viewUser.php" class="no-underline hover:no-underline">
                            <p class="text-2xl font-semibold text-white">Hi <?php echo $_SESSION['firstname'] ?></p>
                        </a>
                    <?php endif; ?>
                </div>
                <nav class="hidden md:flex space-x-10">

                    <a href="#" class="text-base font-medium text-gray-200 hover:text-gray-100">Features</a>
                    <a href="#" class="text-base font-medium text-gray-200 hover:text-gray-100">About</a>
                    <a href="#" class="text-base font-medium text-gray-200 hover:text-gray-100">Contact</a>
                </nav>
                <div class="md:flex items-center justify-end md:flex-1 lg:w-0">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <a href="#" class="whitespace-nowrap text-base font-medium text-gray-200 hover:text-gray-100 px-4">Dashboard</a>
                        <a href="editUser.php" class="whitespace-nowrap text-base font-medium text-gray-200 hover:text-gray-100 px-4">Edit</a>
                        <a href="usermanagement/logout.php" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-blue bg-gray-100 hover:bg-gray-200 md:py-4 md:text-lg md:px-10">Logout</a>
                    <?php else : ?>
                        <a href="login.php" class="whitespace-nowrap text-base font-medium text-gray-200 hover:text-gray-100 px-4">Login</a>
                        <a href="register.php" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-blue bg-gray-100 hover:bg-gray-200 md:py-4 md:text-lg md:px-10">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>
