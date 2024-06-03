<?php

function validate_user_permission($userID, $shelfID, $pdo) {
    // Check if the user is the owner of the shelf
    $stmt = $pdo->prepare("SELECT 1 FROM shelves WHERE shelfID = :shelfID AND shelfOwner = :userID");
    $stmt->execute([':shelfID' => $shelfID, ':userID' => $userID]);
    if ($stmt->fetch()) {
        return true;
    }

    // Check if the user has access to the shelf
    $stmt = $pdo->prepare("SELECT 1 FROM accessibility WHERE shelfID = :shelfID AND userID = :userID");
    $stmt->execute([':shelfID' => $shelfID, ':userID' => $userID]);
    if ($stmt->fetch()) {
        return true;
    }

    return false;
}
?>
