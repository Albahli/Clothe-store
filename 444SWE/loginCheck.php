<?php

session_start();

if(isset($_POST['userName'])  && isset($_POST['password']) && isset($_POST['userType'])){
    
    $userName = $_POST['userName'];
    $password = $_POST['password'];
    $userType = $_POST['userType'];
    
    
    
    
    $host = "localhost";
    $dbUsername = "root";
    $dpPassword = "";
    $dpName = "444SWE";
    
    
    $conn = new mysqli($host , $dbUsername , $dpPassword , $dpName);
  

    if(mysqli_connect_error()){
        
        echo "Failed to connect to database !";
        die();
    
    
    }else{
   
                if($userType == 'Customer'){

                    $sql_u = "SELECT * FROM Customer WHERE userName='$userName';";
                    $sql_p = "SELECT * FROM Customer WHERE password='$password';";

                    $res_u = mysqli_query($conn, $sql_u);
                    $res_p = mysqli_query($conn, $sql_p);

                    $userExist = mysqli_num_rows($res_u);
                    $passwordExist = mysqli_num_rows($res_p);

                    if($userExist > 0 && $passwordExist > 0){
                        
                       
                        
                        $_SESSION['login_user'] = $userName;
                        $_SESSION['user_type'] = 'customer';
                        $_SESSION['customerID'] = '';
                        
                        while($row = mysqli_fetch_assoc($res_u)){
                            
                            $_SESSION['customerID'] = $row['customerID'];
                        }
                        
                        
                        
                         header("Location: home.php?login=UserExist");


                    }else{

                        header("Location: login.php?login=UserError");

                        }



                } else if($userType == 'Designer'){
    

                    $sql_u = "SELECT * FROM Designer WHERE userName='$userName';";
                    $sql_p = "SELECT * FROM Designer WHERE password='$password';";

                    $res_u = mysqli_query($conn, $sql_u);
                    $res_p = mysqli_query($conn, $sql_p);

                    $userExist = mysqli_num_rows($res_u);
                    $passwordExist = mysqli_num_rows($res_p);

                    if($userExist > 0 && $passwordExist > 0){
                            
                         
                        $_SESSION['login_user'] = $userName;
                        $_SESSION['user_type'] = 'designer';
                        $_SESSION['designerID'] = '';
                        $_SESSION['brandName'] = '';
                        
                        while($row = mysqli_fetch_assoc($res_u)){
                            
                            $_SESSION['designerID'] = $row['designerID'];
                            $_SESSION['brandName'] = $row['brandName'];
                        }
                        
                        
                         header("Location: home.php?login=UserExist");


                    }else{

                        header("Location: login.php?login=UserError");

                        }
                    
                }
        
      exit();
    }

            
}
    
    





?>

