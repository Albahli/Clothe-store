<?php
session_start();
if(isset($_POST['submit']))
{

    $productID = $_POST['productID'];
    $numOfRates = 0;
    $customerTotalWeight=0;
    $customerUserName = $_POST['customerUserName'];
    $customerReviewTitle = $_POST['title'];
    $customerReview = $_POST['review'];
    $customerRate = $_POST['rating'];
    $reviewDate = date("Y-m-d");

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

    $stmt = $conn->prepare("INSERT INTO RatedProducts (productID, customerUserName, customerReviewTitle, customerReview, customerRate, reviewDate) VALUES (?, ?, ?, ?, ?, ?);");

    $stmt->bind_param('isssis', $productID, $customerUserName, $customerReviewTitle, $customerReview, $customerRate, $reviewDate);

    $stmt->execute();

    // echo "<meta http-equiv='refresh' content='0'> url= register.html";
    $stmt->close();

    $avg;
    $sql = "SELECT AVG(customerRate) as avgRate FROM RatedProducts WHERE productID=".$productID.";";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck>0)
    {
        while($row = mysqli_fetch_assoc($result))
        {
            $avg = $row['avgRate'];
        }
    }
    if($numOfRates==0 || $numOfRates==-1 || empty($numOfRates))
        $numOfRates=1;

    //$productTotalRate =  $customerTotalWeight / $numOfRates;

    $query1 = $conn->prepare("UPDATE Product SET productTotalRate = ? WHERE productID = ?;");
    $query1->bind_param('di', $avg, $productID); 
    $query1->execute();
    $query1->close();

    $conn->close();

    header("Location: product.php?Product=$productID");
    exit();
} 
else
{
    echo "error";
}
?>