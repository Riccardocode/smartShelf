<?php
session_start();
require '../db.php'; // Include the database connection

if (!isset($_SESSION['user_id'], $_POST['userID'])) {
    header("Location: login.php");
    exit;
}

// Check if the user is allowed to update this profile
if ($_SESSION['user_id'] != $_POST['userID'] && !$_SESSION['is_admin']) {
    echo "You do not have permission to update this profile.";
    exit;
}

$userID = $_POST['userID'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

// Process image upload
$imgProfile = null;
if (isset($_FILES['imgProfile']) && $_FILES['imgProfile']['error'] == 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $filename = $_FILES['imgProfile']['name'];
    $filetype = $_FILES['imgProfile']['type'];
    $filesize = $_FILES['imgProfile']['size'];

    // Verify file extension
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!in_array(strtolower($ext), $allowed)) {
        echo "Error: Invalid file format";
        exit;
    }

    // Verify file size - 5MB maximum
    $maxsize = 5 * 1024 * 1024;
    if ($filesize > $maxsize) {
        echo "Error: File size is larger than the allowed limit";
        exit;
    }

    // Define a new path to store the uploaded file
    $newfilename =  uniqid('', true) . "." . $ext;
    if (!move_uploaded_file($_FILES['imgProfile']['tmp_name'], "../uploads/" . $newfilename)) {
        echo "Error: There was a problem uploading your file. Please try again.";
        exit;
    }

    $imgProfile = $newfilename; // Assign new file path to $imgProfile
    $_SESSION['imgProfile'] = $imgProfile; // Update session variable for immediate display
} else {
    $imgProfile = $_POST['existingImgProfile']; // Handle case where no file is uploaded but an existing image path is available
}

// Update the password only if a new one is provided
$password = $_POST['password'];
$hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

$sql = "UPDATE users SET email = :email, firstname = :firstname, lastname = :lastname, imgProfile = :imgProfile" . ($hashedPassword ? ", password = :password" : "") . " WHERE userID = :userID";

$stmt = $pdo->prepare($sql);
$params = [
    ':email' => $email,
    ':firstname' => $firstname,
    ':lastname' => $lastname,
    ':imgProfile' => $imgProfile,
    ':userID' => $userID
];
if ($hashedPassword) {
    $params[':password'] = $hashedPassword;
}

if ($stmt->execute($params)) {
    header("Location: ../index.php"); // Redirect on success
} else {
    echo "Failed to update profile.";
}
?>
