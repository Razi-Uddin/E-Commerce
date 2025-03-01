<?php
include 'includes/session.php';
$conn = $pdo->open();

$output = array('error'=>false);

$id = $_POST['id'];
$qty = isset($_POST['quantity']) ? $_POST['quantity'] : null;
$color = isset($_POST['color']) ? $_POST['color'] : null;

try{
    if(isset($_SESSION['user'])){
        if($qty !== null) {
            $stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE id=:id");
            $stmt->execute(['quantity'=>$qty, 'id'=>$id]);
        }
        if($color !== null) {
            $stmt = $conn->prepare("UPDATE cart SET color=:color WHERE id=:id");
            $stmt->execute(['color'=>$color, 'id'=>$id]);
        }
    }
    else{
        foreach($_SESSION['cart'] as $key => $row){
            if($row['cartid'] == $id){
                if($qty !== null) {
                    $_SESSION['cart'][$key]['quantity'] = $qty;
                }
                if($color !== null) {
                    $_SESSION['cart'][$key]['color'] = $color;
                }
                break;
            }
        }
    }
}
catch(PDOException $e){
    $output['error'] = true;
    $output['message'] = $e->getMessage();
}

$pdo->close();
echo json_encode($output);
?>
