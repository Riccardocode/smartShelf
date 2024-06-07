<?php
session_start();
require '../../config.php';
require $ROOT_PATH . 'db.php'; // Include the database connection


// Check if templateID is provided
if (!isset($_GET['templateID'])) {
    http_response_code(400);
    echo "Error: templateID not provided.";
    exit;
}

$templateID = (int)$_GET['templateID']; // Get the templateID from the URL

// Prepare the delete statement
$stmt = $pdo->prepare("DELETE FROM product_templates WHERE templateID = :templateID");

// Execute the statement with the templateID
try {
    $stmt->execute([':templateID' => $templateID]);
    echo json_encode(['success' => true]);
    exit;
    
    // header("Location: " . $ROOT_PATH. "product_template/views/viewAllProductsTemplate.php"); // Redirect to the view all products page
    // exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo "Error: " . $e->getMessage();
    exit;
}
?>
