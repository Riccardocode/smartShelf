<?php
session_start();
require 'usermanagement/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login if the user is not logged in
    exit;
}

$userID = $_SESSION['user_id']; // Assuming user_id is stored in the session upon login

// Fetch user data from the database
$sql = "SELECT email, firstname, lastname, imgProfile FROM users WHERE userID = :userID";
$stmt = $pdo->prepare($sql);
$stmt->execute([':userID' => $userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found";  // Handle cases where no user data is found
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script></head>

<body class="bg-gray-100">
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="relative bg-white shadow-lg rounded-lg px-8 py-16 mb-4 w-full max-w-4xl">
        <!-- Profile Image -->
        <div class="absolute left-1/2 transform -translate-x-1/2 -top-16">
            <img src="<?php echo htmlspecialchars("uploads/" . $user['imgProfile']); ?>" alt="Profile Image" class="h-32 w-32 rounded-full border-4 border-white object-cover">
        </div>

        <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Profile</h1>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <p class="bg-gray-50 rounded w-full py-2 px-3 text-gray-700 leading-tight"><?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">First Name:</label>
            <p class="bg-gray-50 rounded w-full py-2 px-3 text-gray-700 leading-tight"><?php echo htmlspecialchars($user['firstname']); ?></p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Last Name:</label>
            <p class="bg-gray-50 rounded w-full py-2 px-3 text-gray-700 leading-tight"><?php echo htmlspecialchars($user['lastname']); ?></p>
        </div>

        <div class="flex justify-center mt-6">
            <a href="editUser.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Edit Profile</a>
        </div>
    </div>
</div>


</body>

</html>