<?php
require 'db.php'; // Include the database connection
include('header.php');



$userID = $_SESSION['user_id']; // Get the logged-in user ID

// Fetch shelves associated with the user
$stmt = $pdo->prepare("SELECT s.shelfID, s.name, s.imgShelf FROM shelves s 
                       JOIN accessibility a ON s.shelfID = a.shelfID 
                       WHERE a.userID = :userID");
$stmt->execute([':userID' => $userID]);
$shelves_access = $stmt->fetchAll();


// Fetch shelves owned by the user
$stmt = $pdo->prepare("SELECT shelfID, name, imgShelf FROM shelves WHERE shelfOwner = :userID");
$stmt->execute([':userID' => $userID]);
$shelves_own = $stmt->fetchAll();
?>

<div class="container mx-auto p-4">
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-4">Shelves You Have Access To</h1>
            <ul>
                <?php if (count($shelves_access) > 0): ?>
                    <?php foreach ($shelves_access as $shelf): ?>
                        <li class="mb-4">
                            <a href="./shelf_management/views/singleShelf.php?shelfID=<?php echo htmlspecialchars($shelf['shelfID']); ?>" class="flex items-center space-x-4">
                                <img src="<?php echo $shelf['imgShelf'] ? "uploads/" . htmlspecialchars($shelf['imgShelf']) : 'default-shelf.png'; ?>" alt="Shelf Image" class="h-16 w-16 rounded-full object-cover">
                                <span class="text-xl font-semibold"><?php echo htmlspecialchars($shelf['name']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You don't have access to any shelves yet.</p>
                <?php endif; ?>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold mb-4">Shelves You Own</h1>
            <ul>
                <?php if (count($shelves_own) > 0): ?>
                    <?php foreach ($shelves_own as $shelf): ?>
                        <li class="mb-4">
                            <a href="./shelf_management/views/singleShelf.php?shelfID=<?php echo htmlspecialchars($shelf['shelfID']); ?>" class="flex items-center space-x-4">
                                <img src="<?php echo $shelf['imgShelf'] ? "uploads/" . htmlspecialchars($shelf['imgShelf']) : 'default-shelf.png'; ?>" alt="Shelf Image" class="h-16 w-16 rounded-full object-cover">
                                <span class="text-xl font-semibold"><?php echo htmlspecialchars($shelf['name']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>You don't own any shelves yet.</p>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>


<?php
include('footer.php');