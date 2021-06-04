<?php
session_start();

if(isset($_POST['email']) && isset($_POST['customerUsername']) && isset($_POST['password']) && isset($_POST['customerContactNumber']) && isset($_POST['customerCity']) && isset($_POST['address']) ){

            
            
    
    
$_SESSION['username']= $_POST['customerUsername'];

$email = $_POST['email'];
$username = $_POST['customerUsername'];
$password = $_POST['password'];
$contactNumber = $_POST['customerContactNumber'];
$city = $_POST['customerCity'];
$address = $_POST['address'];



    $host = "localhost";
    $dbUsername = "root";
    $dpPassword = "";
    $dpName = "444SWE";
    
    
    $conn = new mysqli($host , $dbUsername , $dpPassword , $dpName);
  

    if(mysqli_connect_error()){
        
        echo "Failed to connect to database !";
        die();
    
    }else{
        
        
        $sql_u = "SELECT * FROM Customer WHERE userName='$username';";
        $sql_e = "SELECT * FROM Customer WHERE email='$email';";
  	
        $res_u = mysqli_query($conn, $sql_u);
        $res_e = mysqli_query($conn, $sql_e);
        
        if (mysqli_num_rows($res_u) > 0){
            
             header("Location: register.php?signup=errorCustomerUsername");
             exit();
            
        }else if(mysqli_num_rows($res_e) > 0){
            
              header("Location: register.php?signup=errorCustomerEmail");
              exit();
        
        
        }else{
        
        
        $stmt = $conn->prepare("INSERT INTO Customer (userName, email,
        password, phoneNumber, city, address) VALUES (?, ?, ?, ?, ?, ?);");
        
        $stmt->bind_param('sssiss', $username, $email, $password, $contactNumber, $city, $address);
        
        $stmt->execute();
        
        // echo "<meta http-equiv='refresh' content='0'> url= register.html";
    
        

        }
      
        $stmt->close();
        $conn->close();

      
    header("Location: register.php?signup=successCustomer");
    exit();
      
    }
    
   


    
    
    

}






?>

