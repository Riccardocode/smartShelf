<?php
require '../../config.php';
include $ROOT_PATH . 'header.php';
include "../controllers/controllerEditProductTemplate.php";

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container mx-auto p-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex justify-between items-center p-4">
            <h1 class="text-3xl font-bold">Edit Product</h1>
            <a href="../views/viewAllProductsTemplate.php" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Back to All Products</a>
        </div>
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
            <div class="mb-4 text-center">
                <label for="imgProduct" class="block text-gray-700 mb-2">Product Image</label>
                <div class="inline-flex space-x-4">
                    <input type="file" name="imgProductFile" id="imgProductFile" class="hidden" accept="image/*">
                    <button type="button" onclick="document.getElementById('imgProductFile').click()" class="bg-blue-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-upload mr-2"></i>
                        <span class="hidden sm:inline ml-2">Upload from File</span>
                    </button>

                    <input type="file" name="imgProductCamera" id="imgProductCamera" class="hidden" accept="image/*" capture="environment">
                    <button type="button" onclick="document.getElementById('imgProductCamera').click()" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-camera mr-2"></i>
                        <span class="hidden sm:inline ml-2">Capture from Camera</span>
                    </button>
                </div>
            </div>


            <div class="text-center">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Update</button>
            </div>
        </form>

    </div>
</div>
<?php include $ROOT_PATH . 'footer.php'; ?>
</body>

</html>