<?php
require 'config.php';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Process image upload
    $imgProduct = $product['imgProduct'];
    if (isset($_FILES['imgProduct']) && $_FILES['imgProduct']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['imgProduct']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), $allowed)) {
            $newfilename = uniqid('', true) . "." . $ext;
            if (move_uploaded_file($_FILES['imgProduct']['tmp_name'], "uploads/" . $newfilename)) {
                $imgProduct = $newfilename;
            }
        }
    }

    // Update product
    $stmt = $pdo->prepare("UPDATE product_templates SET name = :name, category = :category, imgProduct = :imgProduct WHERE templateID = :templateID");
    $stmt->execute([':name' => $name, ':category' => $category, ':imgProduct' => $imgProduct, ':templateID' => $templateID]);
    header("Location: view_product.php?templateID=" . $templateID);
    exit;
}
?>


    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-4">Edit Product</h1>
            <form action="edit_product.php?templateID=<?php echo $templateID; ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Product Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-gray-700">Category</label>
                    <input type="text" name="category" id="category" class="w-full p-2 border border-gray-300 rounded-lg" value="<?php echo htmlspecialchars($product['category']); ?>" required>
                </div>
                <div class="mb-4">
                    <label for="imgProduct" class="block text-gray-700">Product Image</label>
                    <input type="file" name="imgProduct" id="imgProduct" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Update Product</button>
            </form>
        </div>
    </div>
    <?php include $ROOT_PATH . 'footer.php'; ?>
</body>
</html>
