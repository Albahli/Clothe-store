<?php
session_start();
?>

<!doctype html>
<html>
    <body class= "justify-content-center" style= "font-family: sans-serif">
        <head>
                <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

              <script src="https://kit.fontawesome.com/a5f9aa2fa3.js" crossorigin="anonymous"></script>

        
        </head>
        
        
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
 <a class="navbar-brand" href="home.php"><img src="logo1.png" style="height:40px; width:40px"></a>
            
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item ">
        <a class="nav-link" href="home.php"> Home <span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Man</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Women</a>
      </li>
         <li class="nav-item">
        <a class="nav-link" href="#">Kids</a>
      </li>
        
     
    
    </ul>
    </div>
    </nav>
        
    <div class="container mx-auto text-center" style="padding-top: 80px">
        
        
       <form action="loginCheck.php" method="post">
           
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control mx-auto" name="userName" id="userName" aria-describedby="userName" placeholder="Fazal" style="max-width:40%" required>
      </div>

      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control mx-auto" name="password" id="exampleInputPassword1" placeholder="••••••••" style="max-width:40%" required>
      </div>

           <div class="form-group">
               
               <div class="form-check form-check-inline">
                   <input class="radio-inline form-check-input" type="radio" name="userType" id="Customer" value="Customer" required>
                   <label class="form-check-label" for="Customer">Customer</label>
               </div>
               <div class="form-check form-check-inline">
                    <input class="radio-inline form-check-input" type="radio" name="userType" id="Designer" value="Designer" required>
                    <label class="form-check-label" for="Designer">Designer</label>
                </div>
         </div>
           
      <button type="submit" class="btn btn-primary" style="width: 10%">Login</button>
          
           
           <p style="padding-top:20px;"><a href="register.php" class="text-muted" >Don't Have an Account ?</a> </p>
           
           <?php      
                        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    
                        if(strpos($url, "login=UserExist") == true){
                            
            echo "<div class='alert alert-success' role='alert' style='margin-top:20px; '> Username Exist. </div>";
                            
                        }else if (strpos($url, "login=UserError") == true){
                        
    echo "<div class='alert alert-danger' role='alert' style='margin-top:20px; '> Username or password is not correct. </div>";
                    
                        } 
                    
                        ?>
           
        </form>
        
            
            
</div>
        
        
 
  
            
        
           
        
        
   
        
        
        
        
       
        
    
        
        
        
        <!-- Footer -->
<footer class="page-footer bg-light font-small" style=" margin-top:80px ">
  <hr>
  <!-- Footer Elements -->
  <div class="container ">

    <!-- Grid row-->
    <div class="row">

      <!-- Grid column -->
      <div class="col-md-4 py-5 mx-auto ">
        <div class="mb-5 d-flex justify-content-around">

          <!-- Facebook -->
          <a class="fb-ic">
            <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
          </a>
          <!-- Twitter -->
          <a class="tw-ic">
            <i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
          </a>
          
          <!--Linkedin -->
          
          <!--Instagram-->
          <a class="ins-ic">
            <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
          </a>
          <!--Pinterest-->
          <a class="pin-ic">
            <i class="fab fa-pinterest fa-lg white-text fa-2x"> </i>
          </a>
        </div>
      </div>
      <!-- Grid column -->
    </div>
    <!-- Grid row-->

  </div>
  <!-- Footer Elements -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="home.html"> Brands.com</a>
  </div>
  <!-- Copyright -->

</footer>
        
        
        
         <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  
    </body>
    
    <script type="text/javascript">
        
        
        
    
    </script>

</html>