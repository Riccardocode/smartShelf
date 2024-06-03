<?php

include('../../header.php');
require $ROOT_PATH . 'db.php'; // Include the database connection

$shelfID = $_GET['shelfID']; // Get shelf ID from URL

// Fetch shelf details
$stmt = $pdo->prepare("SELECT * FROM shelves WHERE shelfID = :shelfID");
$stmt->execute([':shelfID' => $shelfID]);
$shelf = $stmt->fetch();

// Fetch users who have access to this shelf
$stmt = $pdo->prepare("SELECT u.userID, u.firstname, u.lastname FROM accessibility a 
                       JOIN users u ON a.userID = u.userID WHERE a.shelfID = :shelfID");
$stmt->execute([':shelfID' => $shelfID]);
$users = $stmt->fetchAll();

// Fetch products associated with this shelf
$stmt = $pdo->prepare("SELECT * FROM products WHERE shelfID = :shelfID");
$stmt->execute([':shelfID' => $shelfID]);
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shelf Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-4">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center space-x-4">
                <img src="<?php echo $shelf['imgShelf'] ? "../../uploads/" . htmlspecialchars($shelf['imgShelf']) : '../../default-shelf.png'; ?>" alt="Shelf Image" class="h-32 w-32 rounded-full object-cover">
                <div>
                    <h1 class="text-3xl font-bold"><?php echo htmlspecialchars($shelf['name']); ?></h1>
                    <p class="text-gray-700">Owner: <?php echo htmlspecialchars($shelf['shelfOwner']); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg mt-4">
            <h2 class="text-2xl font-bold mb-4">Users with Access</h2>
            <ul>
                <?php foreach ($users as $user) : ?>
                    <li class="border-b border-gray-200 py-2"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg mt-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">Products on this Shelf</h2>
                <a href="<?php echo htmlspecialchars($BASE_URL . "product_management/views/addProduct.php?shelfID=" . $shelfID); ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add New Product</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($products as $product) : ?>
                    <div class="bg-white p-4 rounded-lg shadow">
                        <img src="<?php echo $product['imgProduct'] ? "../../uploads/" . htmlspecialchars($product['imgProduct']) : '../../default-product.png'; ?>" alt="Product Image" class="h-48 w-full object-cover rounded-lg mb-4">
                        <a href="<?php echo htmlspecialchars($BASE_URL . "product_management/views/singleProduct.php?productID=" . $product['productID']); ?>" class="text-blue-500 hover:underline">
                            <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($product['name']); ?></h3>
                        </a>
                        <p class="text-gray-700"><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                        <p class="text-gray-700"><strong>Quantity:</strong> <?php echo htmlspecialchars($product['currentQuantity']); ?></p>
                        <p class="text-gray-700"><strong>Price:</strong> $<?php echo htmlspecialchars($product['price']); ?></p>
                        <p class="text-gray-700"><strong>Expiring Date:</strong> <?php echo htmlspecialchars($product['expiringDate']); ?></p>
                        <div class="mt-4">
                            <a href="edit_product.php?productID=<?php echo htmlspecialchars($product['productID']); ?>" class="text-blue-500 hover:underline">Edit</a>
                            <a href="<?php echo htmlspecialchars($BASE_URL . "product_management/controllers/processRemoveProduct.php?productID=" . $product['productID']); ?>" class="text-red-500 hover:underline ml-2">Remove</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include('../../footer.php'); ?>
</body>

</html>
