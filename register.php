<?php require_once('config.php'); ?>
<?php include($ROOT_PATH . 'header.php') ?>
<div class="flex items-center justify-center align-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm">
        <h2 class="mb-6 text-xl font-bold text-center text-gray-900">Register for SmartShelf</h2>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'specialcharacters') : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Registration failed!</strong>
                <span class="block sm:inline"> Your input contains special characters. Please try again.</span>
            </div>
        <?php endif; ?>
        <form action="usermanagement/process_register.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                <input type="text" id="firstname" name="firstname" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                <input type="text" id="lastname" name="lastname" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="imgProfile" class="block text-gray-700 text-sm font-bold mb-2">Profile Image</label>
                <input type="file" id="imgProfile" name="imgProfile" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Register
                </button>
                <a href="login.php" class="inline-block align-baseline font-bold text-sm text-indigo-600 hover:text-indigo-800">
                    Already have an account?
                </a>
            </div>
        </form>
    </div>
</div>
</div>

<?php include 'footer.php'; ?>