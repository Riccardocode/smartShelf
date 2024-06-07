<?php 
require '../../config.php';
require $ROOT_PATH . 'db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Process image upload
    $imgProduct = null;
    if (isset($_FILES['imgProduct']) && $_FILES['imgProduct']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['imgProduct']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array(strtolower($ext), $allowed)) {
            $newfilename = uniqid('', true) . "." . $ext;
            if (move_uploaded_file($_FILES['imgProduct']['tmp_name'], $ROOT_PATH . "uploads/" . $newfilename)) {
                $imgProduct = $newfilename;
            }
        }
    }

    // Insert new product
    $stmt = $pdo->prepare("INSERT INTO product_templates (name, category, imgProduct) VALUES (:name, :category, :imgProduct)");
    $stmt->execute([':name' => $name, ':category' => $category, ':imgProduct' => $imgProduct]);
    header("Location: " . $BASE_URL . "product_template/views/viewAllProductsTemplate.php");
    exit;
}