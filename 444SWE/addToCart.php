<?php
session_start();
if(isset($_SESSION['customerID']) && $_SESSION['user_type']=='customer' && isset($_POST['productID']))
{
    $productID = $_POST['productID'];
    $customerID = $_POST['customerID'];
    $productSize = $_POST['productSize'];
    $productQuantity = $_POST['productQuantity'];
    $productPrice = $_POST['productPrice'];



    $host = "localhost";
    $dbUsername = "root";
    $dpPassword = "";
    $dpName = "444SWE";


    $conn = new mysqli($host , $dbUsername , $dpPassword , $dpName);


    if(mysqli_connect_error())
    {
        echo "Failed to connect to database !";
        die();

    }


    $stmt = $conn->prepare("INSERT INTO Cart (customerID, productID, productQuantity, productSize, productPrice) VALUES (?, ?, ?, ?, ?);");
    //HERE ,
    $stmt->bind_param('iiisd', $customerID, $productID, $productQuantity, $productSize, $productPrice);

    $stmt->execute();

    // echo "<meta http-equiv='refresh' content='0'> url= register.html"; // <-- refresh 





    $stmt->close();
    $conn->close();
     header("Location: product.php?Product=$productID&Cart=AddedToCart");
}
else
{
    $productID = $_POST['productID'];
    header("Location: product.php?Product=$productID&User=NotRegisterd");
}
?>