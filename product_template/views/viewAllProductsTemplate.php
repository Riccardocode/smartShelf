<?php
require '../../config.php';
session_start();
include $ROOT_PATH . 'header.php';
require $ROOT_PATH . 'db.php'; // Include the database connection

// Fetch all products
$stmt = $pdo->prepare("SELECT * FROM product_templates");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!-- Modal to confirm the deletion -->
<div id="modal" class="hidden fixed inset-0 bg-gray-800 bg-opacity-75 z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Confirm Deletion</h2>
        <p class="mb-4">Are you sure you want to delete this product?</p>
        <div class="flex justify-end">
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2">Cancel</button>
            <a onclick="closeModal()" id="deleteLink" href="#" class="bg-red-500 text-white px-4 py-2 rounded-lg">Delete</a>
        </div>
    </div>
</div>

<div class="container mx-auto p-4"> 
        <h1 class="text-3xl font-bold mb-4">All Products</h1>
        <a href="../views/viewAddNewProductTemplate.php" class="bg-blue-500 text-white px-4 py-2 rounded-lg mb-4 inline-block">Add New Product</a>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($products as $product) : ?>
                <div id="product-<?php echo $product['templateID']; ?>" class="bg-white p-4 rounded-lg shadow">
                    <img src="<?php echo htmlspecialchars($BASE_URL . "uploads/" . $product['imgProduct']); ?>" alt="Product Image" class="h-48 w-full object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="text-gray-700"><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                    <a href="viewSingleProductTemplate.php?templateID=<?php echo $product['templateID']; ?>" class="text-blue-500 hover:underline">View</a>
                    <a href="viewEditProductTemplate.php?templateID=<?php echo $product['templateID']; ?>" class="text-blue-500 hover:underline ml-2">Edit</a>
                    <a href="javascript:void(0);" onclick="openModal(<?php echo $product['templateID']; ?>)" class="text-red-500 hover:underline ml-2">Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include $ROOT_PATH . 'footer.php'; ?>
</body>
<script>
    let currentProductID;

    function openModal(templateID) {
        currentProductID = templateID;
        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal').classList.add('flex');
        // document.getElementById('deleteLink').href = `../controllers/controllerDeleteProductTemplate.php?templateID=${templateID}`;
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('modal').classList.remove('flex');
    }
    document.getElementById('deleteLink').addEventListener('click', function() {
        if (currentProductID) {
            fetch(`../controllers/controllerDeleteProductTemplate.php?templateID=${currentProductID}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`product-${currentProductID}`).remove();
                        closeModal();
                    } else {
                        alert('Error deleting product.');
                    }
                })
                .catch(error => {
                    alert('Error deleting product.');
                });
        }
    });
</script>

</html>