<?php
include 'includes/session.php';

$conn = $pdo->open();

$output = array('error'=>false);

$id = $_POST['id'];
$quantity = $_POST['quantity'];
$color = isset($_POST['color']) ? $_POST['color'] : 'navy blue';

if(isset($_SESSION['user'])){
    // ...
} else {
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }

    $exist = false;

    foreach($_SESSION['cart'] as $key => $row){
        if($row['productid'] == $id && $row['color'] == $color){
            $exist = true;
            $_SESSION['cart'][$key]['quantity'] = $quantity;
        }
    }

    if(!$exist){
        $data['productid'] = $id;
        $data['quantity'] = $quantity;
        $data['color'] = $color;
        $data['unique_id'] = $id . '-' . $color; // add a unique identifier
        if(array_push($_SESSION['cart'], $data)){
            $output['message'] = 'Item added to cart';
        } else {
            $output['error'] = true;
            $output['message'] = 'Cannot add item to cart';
        }
    } else {
        $output['message'] = 'Cart updated';
    }
}

$pdo->close();
echo json_encode($output);
?>