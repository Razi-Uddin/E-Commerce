<?php
include 'includes/session.php';

// Initialize total
$total = 0;

if(isset($_POST['cart'])){
    // Connect to the database
    $conn = $pdo->open();

    // Retrieve cart data from POST request
    $cart = json_decode($_POST['cart'], true);

    foreach($cart as $item){
        // Fetch product details based on product_id
        $stmt = $conn->prepare("SELECT price FROM products WHERE id=:product_id");
        $stmt->execute(['product_id' => $item['product_id']]);
        $product = $stmt->fetch();

        // Calculate subtotal for each item and add to total
        $subtotal = $product['price'] * $item['quantity'];
        $total += $subtotal;
    }

    // Close connection
    $pdo->close();
}

// Return total as JSON response
echo json_encode($total);
?>
