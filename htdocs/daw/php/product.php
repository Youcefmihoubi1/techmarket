<?php
$conn = new mysqli("sql209.byethost8.com", "b8_38963450", "youcefmib500", "b8_38963450_Base_Client");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$product_id = filter_var($_GET['id'] ?? 0, FILTER_VALIDATE_INT);
if ($product_id === false || $product_id <= 0) {
    echo "Invalid product ID.";
    exit;
}
$sql = "SELECT * FROM Product WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit;
}
$image_path = "/daw/images/products/" . htmlspecialchars($product['image']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>TechMarket</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/daw/styles/style.css">
    <script src="/daw/scripts/script.js"></script>
    <link rel="icon" href="/daw/images/icons/logo.jpg">
    <meta name="author" content="Mihoubi Youcef">
</head>
<body>
    <header>
        <table width="100%">
            <tr>
                <td>
                    <a href="/daw/templates/index.html">
                        <h1>TechMarket</h1>
                    </a>
                </td>
                <td align="right">
                    <a href="/daw/templates/login.html">Login</a> |
                    <a href="/daw/templates/signup.html">Sign Up</a>
                    <button onclick="toggleTheme()" style="float:right; margin-right: 10px;">🌓Dark Mode</button>
                </td>
            </tr>
        </table>
    </header>
    <form method="post" action="/daw/php/order.php" id="order">
        <center>
            <h1>Order The Product</h1>
        </center>
        <table border="2" width="40%" align="center">
            <tr>
                <td rowspan="7">
                    <img src="<?php echo $image_path; ?>" alt="Product Image" width="300"
                        title="<?php echo htmlspecialchars($product['ref']); ?>" name="product" id="product"
                        onerror="this.src='/daw/images/icons/placeholder.jpg'">
                </td>
                <td><b>Vendor:</b></td>
                <td><input type="text" id="vendor" value="<?php echo htmlspecialchars($product['vendor']); ?>" name="vendor" readonly></td>
            </tr>
            <tr>
                <td><b>Price:</b></td>
                <td><input type="text" id="price" value="<?php echo htmlspecialchars($product['price']); ?> DA" name="price" readonly></td>
            </tr>
            <tr>
                <td><b>Ref:</b></td>
                <td><input type="text" id="ref" value="<?php echo htmlspecialchars($product['ref']); ?>" name="ref" readonly></td>
            </tr>
            <tr>
                <td><b>Quantity:</b></td>
                <td>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" oninput="check_quantity()" required />
                </td>
            </tr>
            <tr id="colors" style="display:table-row;">
                <td><b>Color:</b></td>
                <td id="color-selection">
                    <label>Black</label>
                    <input type="radio" name="color" value="black" class="color" required />
                    <label>White</label>
                    <input type="radio" name="color" value="white" class="color" />
                </td>
            </tr>
            <tr id="color-quantities" style="display:none;">
                <td><b>Color Quantities:</b></td>
                <td>
                    <label>Black:</label>
                    <input type="number" id="black-quantity" name="black-quantity" min="0" value="0" />
                    <label>White:</label>
                    <input type="number" id="white-quantity" name="white-quantity" min="0" value="0" />
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <button type="button" onclick="validation_order()">Submit Order</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>