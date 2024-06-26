<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Shelf</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Add custom Tailwind CSS configuration if needed */
        /* @tailwind base;
        @tailwind components;
        @tailwind utilities; */
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.getElementById('menu-button');
            const menu = document.getElementById('menu');

            menuButton.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        });
    </script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-indigo-800 py-4 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center ">
                <div class="flex items-center justify-start gap-10 lg:w-0 lg:flex-1">
                    <a href="<?php echo htmlspecialchars($BASE_URL . "index.php"); ?>" class="text-2xl font-bold text-white flex items-center ">SmartShelf</a>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <div class="flex items-center space-x-4">
                            <?php $imagePath = htmlspecialchars($BASE_URL . "uploads/" . $_SESSION['imgProfile']); ?>
                            <img src="<?php echo $imagePath; ?>" alt="Profile Image" class="h-16 w-16 rounded-full border-2 border-white object-cover">
                            <a href="<?php echo htmlspecialchars($BASE_URL . "viewUser.php"); ?>" class="no-underline hover:no-underline">
                                <p class="text-2xl font-semibold text-white">Hi <?php echo htmlspecialchars($_SESSION['firstname']); ?></p>
                            </a>
                            <button onclick="toggleModalBell()" class="relative">
                                <i class="fas fa-bell text-xl"></i>
                                <span id="notificationCount" class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-6 h-6 flex items-center justify-center">
                                    <?php echo count($_SESSION['expiringProducts']); ?>
                                </span>
                            </button>
                            <div id="notificationModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
                                <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
                                    <h2 class="text-xl font-bold mb-4">Expiring Products</h2>
                                    <div id="productList" class="overflow-y-auto max-h-64">
                                        <?php if (!empty($_SESSION['expiringProducts'])) : ?>
                                            <ul>
                                                <?php foreach ($_SESSION['expiringProducts'] as $product) : ?>
                                                    <li class="p-2 border-b border-gray-300">
                                                        <p><strong>Name:</strong> <?php echo htmlspecialchars($product['name']); ?></p>
                                                        <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                                                        <p><strong>Expiring Date:</strong> <?php echo htmlspecialchars($product['expiringDate']); ?></p>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <p>No products expiring soon.</p>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button" onclick="toggleModalBell()" class="bg-red-500 text-white px-4 py-2 rounded-lg mt-4">Close</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- <nav class="hidden md:flex space-x-10">
                    <a href="#" class="text-base font-medium text-gray-200 hover:text-gray-100">Create Shelf</a>
                    <a href="#" class="text-base font-medium text-gray-200 hover:text-gray-100">View Shelf</a>
                    <a href="#" class="text-base font-medium text-gray-200 hover:text-gray-100">Contact</a>
                </nav> -->
                <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <?php if ($_SESSION['isAdmin']) : ?>
                            <a href="<?php echo htmlspecialchars($BASE_URL . "product_template/views/viewAllProductsTemplate.php"); ?>" class="whitespace-nowrap text-base font-medium text-gray-200 hover:text-gray-100 px-4">Product Template</a>
                        <?php endif; ?>
                        <a href="<?php echo htmlspecialchars($BASE_URL . "dashboard.php"); ?>" class="whitespace-nowrap text-base font-medium text-gray-200 hover:text-gray-100 px-4">Dashboard</a>
                        <a href="<?php echo htmlspecialchars($BASE_URL . "editUser.php"); ?>" class="whitespace-nowrap text-base font-medium text-gray-200 hover:text-gray-100 px-4">Edit</a>
                        <a href="<?php echo htmlspecialchars($BASE_URL . "usermanagement/logout.php"); ?>" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-blue bg-gray-100 hover:bg-gray-200 md:py-4 md:text-lg md:px-10">Logout</a>
                    <?php else : ?>
                        <a href="login.php" class="whitespace-nowrap text-base font-medium text-gray-200 hover:text-gray-100 px-4">Login</a>
                        <a href="register.php" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-blue bg-gray-100 hover:bg-gray-200 md:py-4 md:text-lg md:px-10">Register</a>
                    <?php endif; ?>
                </div>
                <div class="md:hidden flex items-center">
                    <button id="menu-button" class="text-gray-200 hover:text-gray-100 focus:outline-none">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div id="menu" class="md:hidden mt-4 space-y-1 hidden">
                <!-- <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-gray-100">Create Shelf</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-gray-100">View Shelf</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-gray-100">Contact</a> -->
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <?php if ($_SESSION['isAdmin']) : ?>
                        <a href="<?php echo htmlspecialchars($BASE_URL . "product_template/views/viewAllProductsTemplate.php"); ?>" class="whitespace-nowrap text-base font-medium text-gray-200 hover:text-gray-100 px-3">Product Template</a>
                    <?php endif; ?>
                    <a href="<?php echo htmlspecialchars($BASE_URL . "dashboard.php"); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-gray-100">Dashboard</a>
                    <a href="<?php echo htmlspecialchars($BASE_URL . "editUser.php"); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-gray-100">Edit</a>
                    <a href="<?php echo htmlspecialchars($BASE_URL . "usermanagement/logout.php"); ?>" class="block px-3 py-2 rounded-md text-base font-medium text-blue bg-gray-100 hover:bg-gray-200">Logout</a>
                <?php else : ?>
                    <a href="login.php" class="block px-3 py-2 rounded-md text-base font-medium text-gray-200 hover:text-gray-100">Login</a>
                    <a href="register.php" class="block px-3 py-2 rounded-md text-base font-medium text-blue bg-gray-100 hover:bg-gray-200">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
</body>
<script>
function toggleModalBell() {
        const modal = document.getElementById('notificationModal');
        modal.classList.toggle('hidden');
    }
</script>
</html>