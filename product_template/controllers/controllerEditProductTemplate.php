<?php 
require '../../config.php';
require $ROOT_PATH . 'db.php'; // Include the database connection

$templateID = (int)$_GET['templateID']; // Get product ID from URL

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM product_templates WHERE templateID = :templateID");
$stmt->execute([':templateID' => $templateID]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    echo "Product not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Process image upload
    $imgProduct = $product['imgProduct'];
    if (isset($_FILES['imgProduct']) && $_FILES['imgProduct']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['imgProduct']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), $allowed)) {
            $newfilename = uniqid('', true) . "." . $ext;
            if (move_uploaded_file($_FILES['imgProduct']['tmp_name'], "uploads/" . $newfilename)) {
                $imgProduct = $newfilename;
            }
        }
    }

    // Update product
    $stmt = $pdo->prepare("UPDATE product_templates SET name = :name, category = :category, imgProduct = :imgProduct WHERE templateID = :templateID");
    $stmt->execute([':name' => $name, ':category' => $category, ':imgProduct' => $imgProduct, ':templateID' => $templateID]);
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: " . $referer);
    exit;
}



?>