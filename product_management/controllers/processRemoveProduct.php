<?php
include('../../config.php');
require $ROOT_PATH . 'db.php'; // Include the database connection
require 'shelf_permission.php';
session_start();



$productID = $_GET['productID']; // Get product ID from URL and cast to integer

// Fetch product details to verify it exists and get shelfID for redirection after deletion
$stmt = $pdo->prepare("SELECT * FROM products WHERE productID = :productID");
$stmt->execute([':productID' => $productID]);
$product = $stmt->fetch();

if (!$product) {
    echo "Error: Product does not exist.";
    exit;
}

$shelfID = $product['shelfID'];
$userID = $_SESSION['user_id'];

$access = validate_user_permission($userID, $shelfID, $pdo);

if (!$access) {
    echo "Error: You do not have permission to delete this product.";
    exit;
}



// Delete the product from the database
$stmt = $pdo->prepare("DELETE FROM products WHERE productID = :productID");

try {
    $stmt->execute([':productID' => $productID]);
    header("Location: " . $BASE_URL . "shelf_management/views/singleShelf.php?shelfID=" . $shelfID); // Redirect to the shelf details page on success
    exit;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

?>