<?php
    $host = "localhost";
    $dbUsername = "root";
    $dpPassword = "";
    $dpName = "444SWE";


    $conn = new mysqli($host , $dbUsername , $dpPassword , $dpName);


    if(mysqli_connect_error()){

        echo "Failed to connect to database !";
        die();
    }


    if(isset($_POST['designerReplay']) && isset($_POST['productID'])){
    

        $designerReplay = $_POST['designerReplay'];
        $productID = $_POST['productID'];
        $reviewID = $_POST['reviewID'];

        $query1 = $conn->prepare("UPDATE RatedProducts SET designerReplay=? WHERE reviewID = ? AND productID = ?;");
        $query1->bind_param('sii', $designerReplay, $reviewID, $productID); 
        $query1->execute();
        $query1->close();
            
        header("Location: product.php?Product=$productID");
        exit();
    }
?>