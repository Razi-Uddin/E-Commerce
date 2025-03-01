<?php
include 'includes/session.php';

$conn = $pdo->open();
$output = array('error' => false);

$id = $_POST['id'];

if(isset($_SESSION['user'])){
    try{
        $stmt = $conn->prepare("DELETE FROM cart WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        $output['message'] = 'Deleted';
    }
    catch(PDOException $e){
        $output['error'] = true;
        $output['message'] = $e->getMessage();
    }
}
else{
    foreach($_SESSION['cart'] as $key => $row){
        if($row['productid'] == $id){
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
            $output['message'] = 'Deleted';
            break;
        }
    }
}

$pdo->close();
echo json_encode($output);
?>
