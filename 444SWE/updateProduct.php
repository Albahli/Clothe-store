<?php
session_start();

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
if(isset($_POST['productID'])){

    $productID = $_POST['productID'];

    if(isset($_POST['productName']) && $_POST['productName']!="")
    {
        $productName = $_POST['productName'];

        $query1 = $conn->prepare("UPDATE Product SET productName=? WHERE productID = ?;");
        $query1->bind_param('si', $productName, $productID); 
        $query1->execute();
        $query1->close();
    }
    if(isset($_POST['productGender']) && $_POST['productGender']!="none")
    {
        $productGender = $_POST['productGender'];

        $query1 = $conn->prepare("UPDATE Product SET productGender=? WHERE productID = ?;");
        $query1->bind_param('si', $productGender, $productID); 
        $query1->execute();
        $query1->close();
    }
    if(isset($productType))
    {
        $productType = $_POST['productType'];

        $query1 = $conn->prepare("UPDATE Product SET productType=? WHERE productID = ?;");
        $query1->bind_param('si', $productType, $productID); 
        $query1->execute();
        $query1->close();
    }
    if(isset($_POST['quantity']) && $_POST['quantity']!='' && $_POST['quantity'] >= 0)
    {
        $productQuantity = $_POST['quantity'];

        $query1 = $conn->prepare("UPDATE Product SET productQuantity=? WHERE productID = ?;");
        $query1->bind_param('ii', $productQuantity, $productID); 
        $query1->execute();
        $query1->close();
    }
    if(isset($_POST['productSize']))
    {
        $productSize = $_POST['productSize'];
        $size = implode(",",$productSize);


        $query1 = $conn->prepare("UPDATE Product SET productSize=? WHERE productID = ?;");
        $query1->bind_param('si', $size, $productID); 
        $query1->execute();
        $query1->close();
    }

    if(isset($_POST['price']) && $_POST['price']>0)
    {
        $productPrice = $_POST['price'];

        $query1 = $conn->prepare("UPDATE Product SET productPrice=? WHERE productID = ?;");
        $query1->bind_param('ii', $productPrice, $productID); 
        $query1->execute();
        $query1->close();
    }

    if(isset($_FILES['fileUpdate']) && $_FILES['fileUpdate']['error'] != UPLOAD_ERR_NO_FILE)
    {
        $file = $_FILES['fileUpdate'];

        //print_r($file); //<-- prints file's date such as name,tmp_name,size error,type
        // exit();
        $fileName = $_FILES['fileUpdate']['name'];
        $fileTmpName = $_FILES['fileUpdate']['tmp_name'];
        $fileSize = $_FILES['fileUpdate']['size'];
        $fileError = $_FILES['fileUpdate']['error'];
        $fileType = $_FILES['fileUpdate']['type'];

        $fileExt = explode('.' , $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png','PNG','JPG','JPEG');

        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){

                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/'. $fileNameNew;

                move_uploaded_file($fileTmpName, $fileDestination);

                $query1 = $conn->prepare("UPDATE Product SET productImage=? WHERE productID = ?;");
                $query1->bind_param('si', $fileDestination, $productID); 
                $query1->execute();
                $query1->close();

            }else{
                header("Location: product.php?Product=$productID&file=error");
                die();
            }

        }else{
            print_r($file);
            header("Location: product.php?Product=$productID&file=formatNotSupported");
            die();
        }
    }
    header("Location: product.php?Product=$productID&product=Updated");
    exit();
}else{
    echo 'productID not set';
}


?>