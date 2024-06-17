<?php
function expiringProducts($userID,$pdo){
    try {
    // Query for products from shelves the user owns
    $sqlOwned = "
        SELECT p.*
        FROM products p
        JOIN shelves s ON p.shelfID = s.shelfID
        WHERE s.shelfOwner = :userID
          AND p.expiringDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)
    ";
    $stmtOwned = $pdo->prepare($sqlOwned);
    $stmtOwned->execute([':userID' => $userID]);
    $ownedProducts = $stmtOwned->fetchAll(PDO::FETCH_ASSOC);

    // Query for products from shelves the user has access to
    $sqlAccessible = "
        SELECT p.*
        FROM products p
        JOIN shelves s ON p.shelfID = s.shelfID
        JOIN accessibility a ON s.shelfID = a.shelfID
        WHERE a.userID = :userID
          AND p.expiringDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)
    ";
    $stmtAccessible = $pdo->prepare($sqlAccessible);
    $stmtAccessible->execute([':userID' => $userID]);
    $accessibleProducts = $stmtAccessible->fetchAll(PDO::FETCH_ASSOC);

    // Combine the results
    $allProducts = array_merge($ownedProducts, $accessibleProducts);
    return $allProducts;
   
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}

?>
