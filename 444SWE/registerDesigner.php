<?php

session_start();

if(isset($_POST['designerEmail']) && isset($_POST['designerUsername']) && isset($_POST['designerPassword']) && isset($_POST['brandName']) && isset($_POST['designerCity']) && isset($_POST['designerContactNumber'])){

            
            
    
    
$_SESSION['designerUsername']= $_POST['designerUsername'];

$email = $_POST['designerEmail'];
$username = $_POST['designerUsername'];
$password = $_POST['designerPassword'];
$brandName = $_POST['brandName'];
$designerCity = $_POST['designerCity'];
$designerContactNumber = $_POST['designerContactNumber'];



    $host = "localhost";
    $dbUsername = "root";
    $dpPassword = "";
    $dpName = "444SWE";
    
    
    $conn = new mysqli($host , $dbUsername , $dpPassword , $dpName);
  

    if(mysqli_connect_error()){
        
        echo "Failed to connect to database !";
        die();
    
    }else{
        
        
        $sql_u = "SELECT * FROM Designer WHERE userName='$username';";
        $sql_e = "SELECT * FROM Designer WHERE email='$email';";
  	
        $res_u = mysqli_query($conn, $sql_u);
        $res_e = mysqli_query($conn, $sql_e);
        
        if (mysqli_num_rows($res_u) > 0){
            
             header("Location: register.php?signup=errorDesignerUsername");
             exit();
            
        }else if(mysqli_num_rows($res_e) > 0){
            
              header("Location: register.php?signup=errorDesignerEmail");
              exit();
        
        
        }else{
        
        
        $stmt = $conn->prepare("INSERT INTO Designer (userName, email,
        password, brandName, phoneNumber, city) VALUES (?, ?, ?, ?, ?, ?);");
        
        $stmt->bind_param('ssssis', $username, $email, $password, $brandName, $designerContactNumber, $designerCity);
        
        $stmt->execute();
        
        // echo "<meta http-equiv='refresh' content='0'> url= register.html";
    
         header("Location: register.php?signup=successDesigner");
         exit();

        }
      
        $stmt->close();
        $conn->close();

     

      
    }
    
   

    

}






?>