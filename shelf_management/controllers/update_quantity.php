<?php
session_start();
require '../../db.php'; // Adjust the path to the correct location
header('Content-Type: application/json');

// Use output buffering to ensure no extraneous output
ob_start();

$response = [];

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not authenticated');
    }

    $productID = $_POST['productID'];
    $action = $_POST['action'];

    if ($action === 'increase') {
        $stmt = $pdo->prepare("UPDATE products SET currentQuantity = currentQuantity + 1 WHERE productID = :productID");
    } elseif ($action === 'decrease') {
        $stmt = $pdo->prepare("UPDATE products SET currentQuantity = currentQuantity - 1 WHERE productID = :productID AND currentQuantity > 0");
    } else {
        throw new Exception('Invalid action');
    }

    $stmt->execute([':productID' => $productID]);

    $stmt = $pdo->prepare("SELECT currentQuantity FROM products WHERE productID = :productID");
    $stmt->execute([':productID' => $productID]);
    $product = $stmt->fetch();

    $response = ['success' => true, 'newQuantity' => $product['currentQuantity']];
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

// Clean (erase) the output buffer and turn off output buffering
ob_end_clean();

// Output the JSON response
echo json_encode($response);
?>
