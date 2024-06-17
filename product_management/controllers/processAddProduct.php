<?php
include('../../config.php');
require $ROOT_PATH . 'db.php'; // Include the database connection
require 'shelf_permission.php';
session_start();

$shelfID =$_GET['shelfID']; // Get shelf ID from URL
$userID = $_SESSION['user_id'];
// Verify that the shelfID exists in the shelves table
$stmt = $pdo->prepare("SELECT * FROM shelves WHERE shelfID = :shelfID");
$stmt->execute([':shelfID' => $shelfID]);
$shelf = $stmt->fetch();

if (!$shelf) {
    echo "Error: Shelf does not exist.";
    echo $shelfID;
    exit;
}

$access = validate_user_permission($userID, $shelfID, $pdo);

if (!$access) {
    echo "Error: You do not have permission to delete this product.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $initialQuantity = filter_input(INPUT_POST, 'initialQuantity', FILTER_SANITIZE_NUMBER_INT);
    $currentQuantity = filter_input(INPUT_POST, 'currentQuantity', FILTER_SANITIZE_NUMBER_INT);
    $buyDate = filter_input(INPUT_POST, 'buyDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $expiringDate = filter_input(INPUT_POST, 'expiringDate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $templateImagePath = $_POST['templateImagePath']; // Get the template image path

    // Process image upload
    $imgProduct = null;
    if (!empty($templateImagePath)) {
        // Use the image path from the template
        $imgProduct = $templateImagePath;
    } else if (isset($_FILES['imgProduct']) && $_FILES['imgProduct']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['imgProduct']['name'];
        $filetype = $_FILES['imgProduct']['type'];
        $filesize = $_FILES['imgProduct']['size'];

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
        if (!move_uploaded_file($_FILES['imgProduct']['tmp_name'], "../../uploads/" . $newfilename)) {
            echo "Error: There was a problem uploading your file. Please try again.";
            exit;
        }

        $imgProduct = $newfilename; // Assign new file path to $imgProduct
    }

    // Insert new product into database
    $sql = "INSERT INTO products (name, category, initialQuantity, currentQuantity, buyDate, expiringDate, imgProduct, price, shelfID) VALUES (:name, :category, :initialQuantity, :currentQuantity, :buyDate, :expiringDate, :imgProduct, :price, :shelfID)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':name' => $name,
            ':category' => $category,
            ':initialQuantity' => $initialQuantity,
            ':currentQuantity' => $currentQuantity,
            ':buyDate' => $buyDate,
            ':expiringDate' => $expiringDate,
            ':imgProduct' => $imgProduct,
            ':price' => $price,
            ':shelfID' => $shelfID
        ]);
        header("Location: " . $BASE_URL . "shelf_management/views/singleShelf.php?shelfID=" . $shelfID); // Redirect to the shelf details page on success
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}
?>
