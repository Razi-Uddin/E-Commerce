<?php
include 'includes/session.php';
$conn = $pdo->open();

$output = array('cartTable' => '', 'cartItems' => array(), 'total' => 0);

function fetchProduct($conn, $productId) {
    $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
    $stmt->execute(['id' => $productId]);
    return $stmt->fetch();
}

function createCartItemRow($product, $row, &$total) {
    $image = (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg';
    $subtotal = $product['price'] * $row['quantity'];
    $total += $subtotal;

    $item = array(
        'photo' => $image,
        'name' => $product['prodname'],
        'color' => $row['color'],
        'price' => number_format($product['price'], 2),
        'quantity' => $row['quantity'],
        'subtotal' => number_format($subtotal, 2)
    );

    $cartRowHtml = "
        <tr>
            <td><button type='button' data-id='" . $row['productid'] . "' class='btn btn-danger btn-flat cart_delete'><i class='fa fa-remove'></i></button></td>
            <td><img src='" . $image . "' width='30px' height='30px'></td>
            <td>" . $product['prodname'] . "</td>
            <td>
            " . $row['color'] . "
            <!-- 
<select class='form-control color-select' data-id='" . $row['productid'] . "' readonly>
    <option value='navy blue'" . ($row['color'] == 'navy blue' ? ' selected' : '') . ">Navy Blue</option>
    <option value='black'" . ($row['color'] == 'black' ? ' selected' : '') . ">Black</option>
    <option value='white'" . ($row['color'] == 'white' ? ' selected' : '') . ">White</option>
    <option value='Red'" . ($row['color'] == 'Red' ? ' selected' : '') . ">Red</option>
    <option value='Yellow'" . ($row['color'] == 'Yellow' ? ' selected' : '') . ">Yellow</option>
    <option value='Royal Blue'" . ($row['color'] == 'Royal Blue' ? ' selected' : '') . ">Royal Blue</option>
    <option value='Light Grey'" . ($row['color'] == 'Light Grey' ? ' selected' : '') . ">Light Grey</option>
    <option value='Dark Grey'" . ($row['color'] == 'Dark Grey' ? ' selected' : '') . ">Dark Grey</option>
    <option value='Cream'" . ($row['color'] == 'Cream' ? ' selected' : '') . ">Cream</option>
    <option value='Baby Pink'" . ($row['color'] == 'Baby Pink' ? ' selected' : '') . ">Baby Pink</option>
    <option value='Zinc'" . ($row['color'] == 'Zinc' ? ' selected' : '') . ">Zinc</option>
    <option value='Peach Pink'" . ($row['color'] == 'Peach Pink' ? ' selected' : '') . ">Peach Pink</option>
    <option value='Lilac'" . ($row['color'] == 'Lilac' ? ' selected' : '') . ">Lilac</option>
    <option value='Mehroon'" . ($row['color'] == 'Mehroon' ? ' selected' : '') . ">Mehroon</option>
</select>
-->

            </td>
            <td>&#36; " . number_format($product['price'], 2) . "</td>
            <td class='input-group'  style='border: none;'>
            " . $row['quantity'] . "
             <!-- 
                <span class='input-group-btn'>
                    <button type='button' class='btn btn-default btn-flat minus' data-id='" . $row['productid'] . "'><i class='fa fa-minus'></i></button>
                </span>
       <input type='text' class='form-control qty' value='" . $row['quantity'] . "' readonly>
                <span class='input-group-btn'>
                    <button type='button' class='btn btn-default btn-flat add' data-id='" . $row['productid'] . "'><i class='fa fa-plus'></i>
                    </button>
                </span>
                -->
            </td>
            <td>&#36; " . number_format($subtotal, 2) . "</td>
        </tr>
    ";

    return array('item' => $item, 'html' => $cartRowHtml);
}

if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $row) {
        $product = fetchProduct($conn, $row['productid']);
        $cartItem = createCartItemRow($product, $row, $output['total']);
        array_push($output['cartItems'], $cartItem['item']);
        $output['cartTable'] .= $cartItem['html'];
    }
    $output['cartTable'] .= "
        <tr>
            <td colspan='6' align='right'><b>Total</b></td>
            <td><b>&#36; " . number_format($output['total'], 2) . "</b></td>
        </tr>
    ";
} else {
    $output['cartTable'] = "<tr><td colspan='7' align='center'>Shopping cart empty</td></tr>";
}

$pdo->close();
echo json_encode($output);
?>
