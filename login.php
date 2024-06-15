<?php require_once('config.php'); ?>

<?php session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit(); // Ensure no further code is executed
}?>

<?php include($ROOT_PATH . 'header.php') ?>
<div class="flex items-center justify-center ">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm mt-20">
        <h2 class="mb-6 text-xl font-bold text-center text-gray-900">Login to SmartShelf</h2>
        <form action="usermanagement/process_login.php" method="POST">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Login
                </button>
                <a href="register.php" class="inline-block align-baseline font-bold text-sm text-indigo-600 hover:text-indigo-800">
                    Need an account?
                </a>
            </div>
        </form>
    </div>
</div>


<?php include($ROOT_PATH . '/footer.php') ?>