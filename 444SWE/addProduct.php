<?php


session_start();

if(isset($_SESSION['designerID'])&& isset($_POST['submit']))
if(isset($_POST['productName']) && isset($_POST['productGender']) && isset($_POST['productType']) && isset($_POST['quantity']) && isset($_POST['price'])){
    
    
    if(!isset($_POST['productSize'])){
         
        header("Location: designer.php?productSize=NotChosen");
        exit();
    }
    
    
    $designer = $_SESSION['designerID'];
    
    $productName = $_POST['productName'];
    $productGender = $_POST['productGender'];
    $productType = $_POST['productType'];
    
    $productSize = $_POST['productSize'];
    
    $size = implode(",",$productSize);
    
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    
    
    $file = $_FILES['file'];
    
    //print_r($file); <-- prints file's date such as name,tmp_name,size error,type
    
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    
    $fileExt = explode('.' , $fileName);
    $fileActualExt = strtolower(end($fileExt));
    
    $allowed = array('jpg', 'jpeg', 'png','PNG','JPG','JPEG');
    
    if(in_array($fileActualExt, $allowed)){
        if($fileError === 0){
            
            $fileNameNew = uniqid('', true).".".$fileActualExt;
            $fileDestination = 'uploads/'. $fileNameNew;
            
            move_uploaded_file($fileTmpName, $fileDestination);
            
            
            


            $host = "localhost";
            $dbUsername = "root";
            $dpPassword = "";
            $dpName = "444SWE";


            $conn = new mysqli($host , $dbUsername , $dpPassword , $dpName);


            if(mysqli_connect_error()){

                echo "Failed to connect to database !";
                die();

            }else{



                $stmt = $conn->prepare("INSERT INTO Product (productDesignerID, productType,
                productName, productPrice, productGender, productSize, productQuantity, productImage) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
                //HERE ,
                $stmt->bind_param('ississis', $designer, $productType, $productName, $price, $productGender, $size, $quantity, $fileDestination);

                $stmt->execute();

                // echo "<meta http-equiv='refresh' content='0'> url= register.html"; // <-- refresh 



                }

                $stmt->close();
                $conn->close();


            header("Location: designer.php?product=Added");
            exit();
            
        }else{
             header("Location: designer.php?file=error");
             die();
            }
        
    }else{
        print_r($file);
         header("Location: designer.php?file=formatNotSupported");
        die();
        }
    

    
    
    
      
    }else {
    echo"error";
    }
    
   


    
    
    








?>

