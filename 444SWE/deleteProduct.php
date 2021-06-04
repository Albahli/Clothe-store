<?php
session_start();

    $host = "localhost";
    $dbUsername = "root";
    $dpPassword = "";
    $dpName = "444SWE";


    $conn = new mysqli($host , $dbUsername , $dpPassword , $dpName);


    if(mysqli_connect_error()){

        echo "Failed to connect to database !";
        die();
    }


    if(isset($_POST['productID'])){
    
        $productID = $_POST['productID'];

        $query1 = $conn->prepare("DELETE FROM Product WHERE productID ='".$productID."';");
        $query1->bind_param('i', $productID); 
        $query1->execute();
        $query1->close();
            
        header("Location: designer.php?product=Deleted");
        exit();
    }
?>