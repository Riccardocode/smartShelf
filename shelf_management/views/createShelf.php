<?php
require_once('../../config.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: " . $BASE_URL . "login.php");
    exit;
}
include('../../header.php');

?>
<div class="container mx-auto p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4">Create New Shelf</h1>
        <form action="../controllers/process_shelf_creation.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Shelf Name</label>
                <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="imgShelf" class="block text-gray-700">Shelf Image</label>
                <input type="file" name="imgShelf" id="imgShelf" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label for="accessEmails" class="block text-gray-700">User Emails for Access (comma-separated)</label>
                <textarea name="accessEmails" id="accessEmails" class="w-full p-2 border border-gray-300 rounded-lg" required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Create Shelf</button>
        </form>
    </div>
</div>
</body>
</html>
