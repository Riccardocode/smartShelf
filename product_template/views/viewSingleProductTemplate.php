<?php
session_start();
require '../../config.php';
include $ROOT_PATH . 'header.php';
require $ROOT_PATH . 'db.php'; // Include the database connection

$templateID = (int)$_GET['templateID']; // Get product ID from URL

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM product_templates WHERE templateID = :templateID");
$stmt->execute([':templateID' => $templateID]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    echo "Product not found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($product['name']); ?></h1>
            <img src="<?php echo htmlspecialchars($BASE_URL . "uploads/" . $product['imgProduct']); ?>" alt="Product Image" class="h-64 w-full object-cover rounded-lg mb-4">
            <p class="text-xl"><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
            <div class="mt-4">
                <a href="edit_product.php?templateID=<?php echo $product['templateID']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Edit Product</a>
                <a href="delete_product.php?templateID=<?php echo $product['templateID']; ?>" class="bg-red-500 text-white px-4 py-2 rounded-lg ml-2">Delete Product</a>
            </div>
        </div>
    </div>
    <?php include $ROOT_PATH . 'footer.php'; ?>
</body>
</html>
