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
            <img src="<?php echo $shelf['imgShelf'] ? "../../uploads/" . htmlspecialchars($shelf['imgShelf']) : 'default-shelf.png'; ?>" alt="Shelf Image" class="h-32 w-32 rounded-full object-cover">
            <div>
                <h1 class="text-3xl font-bold"><?php echo htmlspecialchars($shelf['name']); ?></h1>
                <p class="text-gray-700">Owner: <?php echo htmlspecialchars($shelf['shelfOwner']); ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg mt-4">
        <h2 class="text-2xl font-bold mb-4">Users with Access</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li class="border-b border-gray-200 py-2"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg mt-4">
        <h2 class="text-2xl font-bold mb-4">Products on this Shelf</h2>
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200 text-gray-600">
                <tr>
                    <th class="py-2 px-4">Product Name</th>
                    <th class="py-2 px-4">Category</th>
                    <th class="py-2 px-4">Quantity</th>
                    <th class="py-2 px-4">Price</th>
                    <th class="py-2 px-4">Expiring Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="border-t border-gray-200 py-2 px-4"><?php echo htmlspecialchars($product['name']); ?></td>
                        <td class="border-t border-gray-200 py-2 px-4"><?php echo htmlspecialchars($product['category']); ?></td>
                        <td class="border-t border-gray-200 py-2 px-4"><?php echo htmlspecialchars($product['currentQuantity']); ?></td>
                        <td class="border-t border-gray-200 py-2 px-4"><?php echo htmlspecialchars($product['price']); ?></td>
                        <td class="border-t border-gray-200 py-2 px-4"><?php echo htmlspecialchars($product['expiringDate']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../../footer.php'); ?>
</body>
</html>
