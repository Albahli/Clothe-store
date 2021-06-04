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


    if(isset($_POST['productID']) && isset($_POST['customerID'])){
    
        $productID = $_POST['productID'];
        $customerID = $_POST['customerID'];
        
        $query1 = $conn->prepare("DELETE FROM Cart WHERE productID ='".$productID."' AND customerID='".$customerID."' ;");
        $query1->bind_param('ii', $productID, $customerID); 
        $query1->execute();
        $query1->close();
            
        header("Location: cart.php?Cart=Deleted");
        exit();
    }
?>