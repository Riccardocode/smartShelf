<?php
require '../../config.php';
include $ROOT_PATH . 'header.php';
include "../controllers/controllerEditProductTemplate.php";

?>

    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-4">Edit Product</h1>
            <?php if ($product['imgProduct']) : ?>
                <img src="<?php echo htmlspecialchars($BASE_URL . "uploads/" . $product['imgProduct']); ?>" alt="Product Image" class="h-64 w-full object-cover rounded-lg mb-4">
            <?php endif; ?>
            <form action="../controllers/controllerEditProductTemplate.php?templateID=<?php echo $templateID; ?>" method="POST" enctype="multipart/form-data">
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
                    <input type="file" name="imgProduct" id="imgProduct" class="w-full p-2 border border-gray-300 rounded-lg" accept="image/*" capture="environment">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Update Product</button>
                <a href="../views/viewAllProductsTemplate.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Back to All Products</a>
            </form>
            
        </div>
    </div>
    <?php include $ROOT_PATH . 'footer.php'; ?>
</body>
</html>
