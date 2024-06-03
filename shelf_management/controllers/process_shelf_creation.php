<?php
session_start();
require '../../db.php'; // Include the database connection

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $accessEmails = filter_input(INPUT_POST, 'accessEmails', FILTER_SANITIZE_EMAIL);

    // Process image upload
    $imgShelf = null;
    if (isset($_FILES['imgShelf']) && $_FILES['imgShelf']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['imgShelf']['name'];
        $filetype = $_FILES['imgShelf']['type'];
        $filesize = $_FILES['imgShelf']['size'];
        
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
        $newfilename = uniqid('', true) . "." . $ext;
        if (!move_uploaded_file($_FILES['imgShelf']['tmp_name'], "../../uploads/" . $newfilename)) {
            echo "Error: There was a problem uploading your file. Please try again.";
            exit;
        }

        $imgShelf = $newfilename; // Assign new file path to $imgShelf
    }

    // Insert new shelf into database
    $sql = "INSERT INTO shelves (shelfOwner, name, imgShelf) VALUES (:shelfOwner, :name, :imgShelf)";
    $stmt = $pdo->prepare($sql);
    $shelfOwner = $_SESSION['user_id'];

    try {
        $stmt->execute([
            ':shelfOwner' => $shelfOwner,
            ':name' => $name,
            ':imgShelf' => $imgShelf
        ]);
        $shelfID = $pdo->lastInsertId();

        // Grant access to users
        $emails = explode(',', $accessEmails);
        foreach ($emails as $email) {
            $email = trim($email);
            // Get userID from email
            $stmt = $pdo->prepare("SELECT userID FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if ($user) {
                $userID = $user['userID'];
                // Insert into accessibility table
                $stmt = $pdo->prepare("INSERT INTO accessibility (userID, shelfID) VALUES (:userID, :shelfID)");
                $stmt->execute([
                    ':userID' => $userID,
                    ':shelfID' => $shelfID
                ]);
            }
        }

        header('Location: /smartshelf/index.php'); // Redirect to homepage on success
        exit;
    } catch (PDOException $e) {
        // Redirect back to the create shelf page with an error message
        header("Location: ../create_shelf.php?error=sqlerror");
        exit;
    }
}
?>
