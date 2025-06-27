<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['Id_Clt'])) {
    echo "<script>alert('❌ You must be logged in to place an order.'); window.location.href='/daw/templates/login.html';</script>";
    exit;
}

$conn = new mysqli("sql209.byethost8.com", "b8_38963450", "youcefmib500", "b8_38963450_Base_Client");
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

$ref = $_POST['ref'] ?? '';
$vendor = $_POST['vendor'] ?? '';
$price = str_replace(' DA', '', $_POST['price'] ?? '');
$price = floatval($price);
$quantity = intval($_POST['quantity'] ?? 0);
$color = '';

if ($quantity === 1) {
    $color = $_POST['color'] ?? '';
} else {
    $colors = $_POST['color'] ?? [];
    if ($quantity > 2) {
        $black_quantity = intval($_POST['black-quantity'] ?? 0);
        $white_quantity = intval($_POST['white-quantity'] ?? 0);
        $color_parts = [];
        if ($black_quantity > 0) {
            $color_parts[] = "black:$black_quantity";
        }
        if ($white_quantity > 0) {
            $color_parts[] = "white:$white_quantity";
        }
        $color = implode(',', $color_parts);
    } else {
        $color = is_array($colors) ? implode(',', $colors) : $colors;
    }
}

if ($ref === '' || $vendor === '' || $price <= 0 || $quantity <= 0 || $color === '') {
    error_log("Invalid form data: ref=$ref, vendor=$vendor, price=$price, quantity=$quantity, color=$color");
    echo "<script>alert('❌ Invalid form data. Please ensure all fields are filled correctly.'); window.location.href='/daw/php/product_order.php?id=" . urlencode($_POST['product_id'] ?? '') . "';</script>";
    exit;
}

$id_client = $_SESSION['Id_Clt'];

$sql = "INSERT INTO Commande_produit (Ref_prod, Vendeur_prod, Prix_prod, Qant_prod, Colr_prod, id_client)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    die("❌ Error preparing query: " . $conn->error);
}

$stmt->bind_param("ssdisi", $ref, $vendor, $price, $quantity, $color, $id_client);

if ($stmt->execute()) {
    echo "<script>alert('✅ Order submitted successfully!'); window.location.href='/daw/templates/index.html';</script>";
} else {
    error_log("Error inserting order: " . $stmt->error);
    echo "<script>alert('❌ Error inserting order: " . $stmt->error . "'); window.location.href='/daw/php/product_order.php?id=" . urlencode($_POST['product_id'] ?? '') . "';</script>";
}

$stmt->close();
$conn->close();
?>