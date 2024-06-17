<?php
require '../db.php'; // Include the database connection

// Function to compare original and sanitized inputs
function validate_input($original, $sanitized) {
    return $original === $sanitized;
}

// Sanitize inputs
$original_firstname = $_POST['firstname'];
$original_lastname = $_POST['lastname'];
$original_email = $_POST['email'];

$firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

// Check if sanitized inputs are equal to original inputs
if (!validate_input($original_firstname, $firstname) ||
    !validate_input($original_lastname, $lastname) ||
    !validate_input($original_email, $email)) {
    // Redirect to the register page with an error message
    header("Location: ../register.php?error=specialcharacters", true, 302);
    exit;
}

$password = $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

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
        header("Location: ../register.php?error=invalidfileformat", true, 302);
        exit;
    }

    // Verify file size - 5MB maximum
    $maxsize = 5 * 1024 * 1024;
    if ($filesize > $maxsize) {
        header("Location: ../register.php?error=filetoolarge", true, 302);
        exit;
    }

    // Define a new path to store the uploaded file
    $newfilename = uniqid('', true) . "." . $ext;
    if (!move_uploaded_file($_FILES['imgProfile']['tmp_name'], "../uploads/" . $newfilename)) {
        header("Location: ../register.php?error=fileuploaderror", true, 302);
        exit;
    }

    $imgProfile = $newfilename; // Assign new file path to $imgProfile
} else {
    $imgProfile = null; 
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
    header('Location: ../index.php', true, 200); // Redirect to homepage on success
    exit;
} catch (\PDOException $e) {
    // Redirect back to the register page with an error message
    header("Location: ../register.php?error=sqlerror", true, 302);
    exit;
}
?>
