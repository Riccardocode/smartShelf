<?php
session_start(); // Start the session at the very beginning
require 'db.php'; // Include the database connection

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password']; // Get the password directly

// Prepare SQL statement to prevent SQL injection
$stmt = $pdo->prepare("SELECT userID, email, firstname, imgProfile, password FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    // If the password is correct, start a session
    $_SESSION['user_id'] = $user['userID'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['firstname'] = $user['firstname'];
    $_SESSION['imgProfile'] = $user['imgProfile'];
    header("Location: ../index.php"); // Redirect to a logged-in page
    exit;
} else {
    // If login was not successful, send back to the login page with an error message
    header("Location: ../login.php?error=invalidcredentials");
    exit;
}

?>
