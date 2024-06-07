<?php
require '../config.php';
require $ROOT_PATH . 'db.php'; // Include the database connection
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, return a 401 Unauthorized response
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
    // Fetch products from product_template table
    $stmt = $pdo->prepare("SELECT templateId, name, category, imgProduct FROM product_templates");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($products);
} catch (PDOException $e) {
    // Return a 500 Internal Server Error response if something goes wrong
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch products']);
}
?>
