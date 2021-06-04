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

if(isset($_POST['customerID']))
{
    $customerID = $_POST['customerID'];
    $purchaseDate = date("Y-m-d");

    $sqlCustomer= "SELECT * FROM Cart WHERE customerID='".$customerID."';";
    $resultCustomer= mysqli_query($conn,$sqlCustomer);
    $resultCustomerCheck= mysqli_num_rows($resultCustomer);

    $productID;
    $productQuantity = 1;
    $mailTo ;

    if($resultCustomerCheck>0)
    {
        while($row=mysqli_fetch_assoc($resultCustomer))
        {
            $query1 = $conn->prepare("INSERT INTO PurchasedProducts (customerID, productID, productPrice, productQuantity, purchaseDate) VALUES (?,?,?,?,?) ;");

            $productID = $row['productID'];
            $productPrice = $row['productPrice'];
            $productQuantity = $row['productQuantity'];

            $query1->bind_param('iiiis', $customerID, $productID, $productPrice, $productQuantity, $purchaseDate); 
            $query1->execute();

        }
        $query1->close();

        $query2 = $conn->prepare("DELETE FROM Cart WHERE customerID='".$customerID."' ;");
        $query2->bind_param('i', $customerID); 
        $query2->execute();
        $query2->close();

        $query3 = $conn->prepare("UPDATE Product SET productQuantity = productQuantity - ".$productQuantity." WHERE productID='".$productID."' ;");
        $query3->bind_param('ii', $customerID, $productID); 
        $query3->execute();
        $query3->close();


        if(isset($mailTo))
        {
            $subject = "Testing message subject";
            // $mailTo = "faisal-a5@live.com";
            $txt = "Testing message body";
            $headers = "From: My website"; 
            //mail($mailTo, $subject, $txt, $headers);


            echo $subject.", ".$mailTo.", ".$txt.", ".$headers;
            die();
        }
        else{
            die("email not set");
        }
    }


    header("Location: cart.php?Cart=Purchased");
    exit();
}
else
{
    echo "error";
}
?>