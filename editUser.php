<?php
session_start();
require 'db.php'; // Include database connection
include('header.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Not logged in, redirect to login
    exit;
}

$editUserId = $_GET['id'] ?? $_SESSION['user_id']; // ID from GET or the logged-in user's ID as fallback

// Check if the logged-in user is an admin or editing their own profile
if ($_SESSION['user_id'] != $editUserId && !$_SESSION['is_admin']) {
    echo "You do not have permission to edit this profile.";
    exit;
}

// Fetch user details from the database
$stmt = $pdo->prepare("SELECT * FROM users WHERE userID = :userID");
$stmt->execute([':userID' => $editUserId]);
$user = $stmt->fetch();

if (!$user) {
    echo "User not found.";
    exit;
}

// Display form with user data
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="relative bg-white shadow-lg rounded-lg px-8 py-16 mb-4 w-full max-w-4xl">
        <!-- Profile Image -->
        <div class="absolute left-1/2 transform -translate-x-1/2 -top-16">
            <img src="<?php echo htmlspecialchars("uploads/" . $user['imgProfile']); ?>" alt="Profile Image" class="h-32 w-32 rounded-full border-4 border-white object-cover">
        </div>

        <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Edit Profile</h1>
        <form action="usermanagement/process_edit_user.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="userID" value="<?php echo htmlspecialchars($user['userID']); ?>">

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                <input type="email" id="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            
            <div class="mb-4">
                <label for="firstname" class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
                <input type="text" id="firstname" name="firstname" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            </div>
            
            <div class="mb-4">
                <label for="lastname" class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
                <input type="text" id="lastname" name="lastname" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password (leave blank if you do not want to change it):</label>
                <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="mb-6">
                <label for="imgProfile" class="block text-gray-700 text-sm font-bold mb-2">Change Profile Image:</label>
                <input type="file" id="imgProfile" name="imgProfile" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none focus:border-transparent" accept="image/*" capture="user">
            </div>
            
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">Update Profile</button>
        </form>
    </div>
</div>



</body>

</html>