<?php session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit(); // Ensure no further code is executed
}
?>
<?php require_once('config.php'); ?>
<?php include($ROOT_PATH . 'header.php');?>
    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-5xl xl:text-6xl">
                            <span class="block xl:inline">Manage Your Shelves</span>
                            <span class="block text-indigo-600 xl:inline">Efficiently & Smartly</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            SmartShelf helps you organize and track your products with ease, ensuring no item is ever out of place or past its due date.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-center">
                            <div class="rounded-md shadow">
                                <a href="./login.php" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Get started
                                </a>
                            </div>
                           
                        </div>
                    </div>
                </main>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="./assets/img/hero1.png" alt="Fruit and fridge">
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Why SmartShelf?</h2>
                <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <p class="text-lg leading-relaxed text-gray-500">Track expiration dates and replenish efficiently.</p>
                    </div>
                    <div class="text-center">
                        <p class="text-lg leading-relaxed text-gray-500">Automatically manage inventory with intelligent analytics.</p>
                    </div>
                    <div class="text-center">
                        <p class="text-lg leading-relaxed text-gray-500">Access from anywhere, on any device, securely and reliably.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-indigo-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-8">
                <p class="text-center text-gray-200 text-sm">
                    &copy; 2024 SmartShelf. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>