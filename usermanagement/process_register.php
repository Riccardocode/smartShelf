<?php
require 'db.php'; // Include the database connection file

// Sanitize inputs
$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Handle file upload
$imgProfile = null;
if (isset($_FILES['imgProfile']) && $_FILES['imgProfile']['error'] === UPLOAD_ERR_OK) {
    // Check if file is an image and sanitize the file name
    $fileTmpPath = $_FILES['imgProfile']['tmp_name'];
    $fileName = basename($_FILES['imgProfile']['name']);
    $fileNameCmps = explode('.', $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $sanitizedFileName = filter_var($fileNameCmps[0], FILTER_SANITIZE_FULL_SPECIAL_CHARS) . '.' . $fileExtension;

    // Allowed file types
    $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg'];
    if (in_array($fileExtension, $allowedfileExtensions)) {
        // File upload path
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . $sanitizedFileName;

        // Move the file to the upload directory
        if (move_uploaded_file($fileTmpPath, $uploadFile)) {
            $imgProfile = $uploadFile; // URL to be saved in the database
        } else {
            header('Location: register.php?error=upload');
            exit;
        }
    } else {
        header('Location: register.php?error=filetype');
        exit;
    }
}

// SQL to insert new user using prepared statements
$sql = "INSERT INTO users (firstname, lastname, email, password, imgProfile) VALUES (:firstname, :lastname, :email, :password, :imgProfile)";
$stmt = $pdo->prepare($sql);

try {
    $stmt->execute([
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':imgProfile' => $imgProfile
    ]);
    header('Location: ../index.php'); // Redirect to homepage on success
    exit;
} catch (\PDOException $e) {
    // Redirect back to the register page with an error message
    header("Location: ../register.php?error=sqlerror");
    exit;
}
?>