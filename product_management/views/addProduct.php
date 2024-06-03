<?php $shelfID =$_GET['shelfID']; // Get shelf ID from URL
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
        <form action=<?php echo htmlspecialchars("../controllers/processAddProduct.php?shelfID=" . $shelfID); ?> method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Product Name</label>
                <input type="text" name="name" id="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="category" class="block text-gray-700">Category</label>
                <input type="text" name="category" id="category" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="initialQuantity" class="block text-gray-700">Initial Quantity</label>
                <input type="number" name="initialQuantity" id="initialQuantity" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="currentQuantity" class="block text-gray-700">Current Quantity</label>
                <input type="number" name="currentQuantity" id="currentQuantity" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="buyDate" class="block text-gray-700">Buy Date</label>
                <input type="date" name="buyDate" id="buyDate" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="expiringDate" class="block text-gray-700">Expiring Date</label>
                <input type="date" name="expiringDate" id="expiringDate" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label for="price" class="block text-gray-700">Price</label>
                <input type="number" step="0.01" name="price" id="price" class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="imgProduct" class="block text-gray-700">Product Image</label>
                <input type="file" name="imgProduct" id="imgProduct" class="w-full p-2 border border-gray-300 rounded-lg">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Product</button>
        </form>
    </div>
</div>
</body>
</html>
