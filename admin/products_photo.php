<?php
    include 'includes/session.php';

    if(isset($_POST['upload'])){
        $id = $_POST['id'];
        $filename = $_FILES['photo']['name'];

        $conn = $pdo->open();

        $stmt = $conn->prepare("SELECT * FROM products WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        $row = $stmt->fetch();

        if(!empty($filename)){
            $new_filename = $filename; // Keep the original filename
            move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);    
        }
        
        try{
            $stmt = $conn->prepare("UPDATE products SET photo=:photo WHERE id=:id");
            $stmt->execute(['photo'=>$new_filename, 'id'=>$id]);
            $_SESSION['success'] = 'Product photo updated successfully';
        }
        catch(PDOException $e){
            $_SESSION['error'] = $e->getMessage();
        }

        $pdo->close();

    }
    else{
        $_SESSION['error'] = 'Select product to update photo first';
    }

    header('location: products.php');
?>
