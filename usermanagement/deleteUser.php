<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'], $_GET['userID'])) {
    header("Location: login.php"); // Redirect to login if user or ID is not in the session
    exit;
}

// Ensure that the user is deleting only their own profile unless they are an admin
if ($_SESSION['user_id'] != $_GET['userID'] && !$_SESSION['is_admin']) {
    echo "You do not have permission to delete this profile.";
    exit;
}

$userID = $_GET['userID'];

// Prepare and execute the delete statement
$sql = "DELETE FROM users WHERE userID = :userID";
$stmt = $pdo->prepare($sql);
if ($stmt->execute([':userID' => $userID])) {
    // Optionally, destroy the session if the user deletes their own profile
    if ($_SESSION['user_id'] == $userID) {
        session_destroy();
        header("Location: ../index.php"); // Redirect to login page after deleting
    } else {
        header("Location: usersList.php"); // Redirect to users list if admin deleted another user
    }
    exit;
} else {
    echo "Failed to delete profile.";
}
?>
