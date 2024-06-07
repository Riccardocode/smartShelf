<?php

require '../../config.php';
include $ROOT_PATH . 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-4">Add New Product</h1>
            <form action="../controllers/controllerAddNewProductTemplate.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Product Name</label>
                    <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-gray-700">Category</label>
                    <input type="text" name="category" id="category" class="w-full p-2 border border-gray-300 rounded-lg" required>
                </div>
                <div class="mb-4">
                    <label for="imgProduct" class="block text-gray-700">Product Image</label>
                    <input type="file" name="imgProduct" id="imgProduct" class="w-full p-2 border border-gray-300 rounded-lg">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Product</button>
            </form>
        </div>
    </div>
    <?php include $ROOT_PATH . 'footer.php'; ?>
</body>
</html>
