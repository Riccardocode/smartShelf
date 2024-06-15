<?php
session_start();
include("../../header.php");

require $ROOT_PATH . 'db.php'; // Include the database connection
require $ROOT_PATH . 'product_management/controllers/shelf_permission.php'; // Include the permission validation

$userID = $_SESSION['user_id']; // Get the logged-in user ID
$productID = (int)$_GET['productID']; // Get product ID from URL and cast to integer

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE productID = :productID");
$stmt->execute([':productID' => $productID]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    require $ROOT_PATH . '404.php';
    exit;
}

$shelfID = $product['shelfID'];

// Validate user permission
$access = validate_user_permission($userID, $shelfID, $pdo);

if (!$access) {
    http_response_code(403);
    echo "Error: You do not have permission to view this product.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
        <div class="mb-4">
            <img src="<?php echo $product['imgProduct'] ? $BASE_URL . 'uploads/' . htmlspecialchars($product['imgProduct']) : $BASE_URL . 'default-product.png'; ?>" alt="Product Image" class="h-64 w-64 object-cover rounded-lg mx-auto">
        </div>
        <p class="text-xl"><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
        <p class="text-xl"><strong>Initial Quantity:</strong> <?php echo htmlspecialchars($product['initialQuantity']); ?></p>
        <p class="text-xl"><strong>Current Quantity:</strong> <?php echo htmlspecialchars($product['currentQuantity']); ?></p>
        <p class="text-xl"><strong>Buy Date:</strong> <?php echo htmlspecialchars($product['buyDate']); ?></p>
        <p class="text-xl"><strong>Expiring Date:</strong> <?php echo htmlspecialchars($product['expiringDate']); ?></p>
        <p class="text-xl"><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
        <div class="mt-4">
            <a href="edit_product.php?productID=<?php echo htmlspecialchars($productID); ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Edit Product</a>
            <a href="delete_product.php?productID=<?php echo htmlspecialchars($productID); ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg ml-2">Delete Product</a>
        </div>
    </div>
</div>
</body>
</html>
