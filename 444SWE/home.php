<?php
session_start();

$userExist = false;

if(isset($_SESSION['login_user'])){

    $loggedUser = $_SESSION['login_user'];

    if(isset($_SESSION['user_type'])){

        $userType = $_SESSION['user_type']; // user type : customer , designer

        $userExist = true;

    }
}

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

?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <style>
            * {
                font-family: sans-serif;
            }

            .product-card
            {
                opacity: 1
            }

            .product-card:hover
            {
                opacity: 0.6;
                transition: 0.3s;
            }
        </style>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <script src="https://kit.fontawesome.com/a5f9aa2fa3.js" crossorigin="anonymous"></script>

        <title>BRANDS</title>
    </head>

    <body class="font-weight-light" style="font-family: sans-serif">

        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <a class="navbar-brand" href="home.php"><img src="logo1.png" style="height:40px; width:40px"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                        <a class="nav-link" href="home.php">Home <span class="sr-only"></span></a>
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


                <ul class="navbar-nav ml-auto">

                    <?php if($userExist && $userType=='customer')
{

    echo "<li class=' nav-item '>
        <a class='nav-link' href='profile.php'><span class='fas fa-user'></span> " .$_SESSION['login_user']. "</a>
      </li>

     <li class='nav-item'>
        <a class='nav-link' href='cart.php'><span class='fas fa-shopping-cart'></span> Shopping Cart</a>
      </li>

    <li class='nav-item'>
        <a class='nav-link' href='logout.php'><span class='fas fa-sign-out-alt'></span> Logout</a>
      </li>";

}else if($userExist && $userType='designer'){

    echo "<li class='nav-item   '>
        <a class='nav-link ' href='designerProfile.php'><span class='fas fa-user'></span> " .$_SESSION['login_user']. "</a>
      </li>

     <li class='nav-item '>
        <a class='nav-link' href='designer.php'><span class='fas fa-box'></span> My Products</a>
      </li>

    <li class='nav-item '>
        <a class='nav-link' href='logout.php'><span class='fas fa-sign-out-alt'></span> Logout</a>
      </li>";


}else{
    echo "<li class='nav-item'>
        <a class='nav-link' href='login.php'><span class='fas fa-sign-in-alt'></span> Login</a>
      </li>

       <li class='nav-item'>
        <a class='nav-link' href='register.php'><span class='fas fa-user-plus'></span> Register</a>
      </li>" ;



}

                    ?>



                </ul>
            </div>
        </nav>


        <div id="carousel" class="carousel slide" data-ride="carousel" >
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class=""></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner" style="height:600px" >
                <div class="carousel-item active">
                    <img src="z2.jpeg" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item">
                    <img src="z1.jpg" class="d-block w-100" alt="...">
                </div>

                <div class="carousel-item">
                    <img src="mm3x.png" class="d-block w-100" alt="...">
                </div>

            </div>

            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
        <div class="input-group mb-2 mt-5 w-75 mx-auto">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"><span class="fas fa-search"></span></span>
            </div>
            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="search" placeholder="Search for designer">
        </div>
        <hr>
        <div class="container mx-auto  mt-3 p-4" id="brands">
            <div class="row d-flex flex-row justify-content-around text-center">
                <?php 
                $sqlDesigner = "SELECT * FROM Designer;";
                $resultDesigner = mysqli_query($conn,$sqlDesigner);
                $resultDesignerCheck = mysqli_num_rows($resultDesigner);

                if($resultDesignerCheck > 0)
                {          

                    while($row = mysqli_fetch_assoc($resultDesigner))
                    {

                ?>

                <div class="<?php echo $row['brandName']; ?> bg-light font-weight-light " style="margin-top:25px" id="brandslist">
                    <a class="text-muted " href="designerBrand.php?<?php echo "id=".$row['designerID']; ?>" style="text-decoration: none;">
                        <div class="border  align-items-center product-card rounded ">

                            <img class="flex text-center rounded-top" src="<?php echo $row['brandLogo']; ?>" style="vertical-align: middle;"  width="300px;" height="230px">

                            <h2 class="p-1 mt-2 text-muted font-weight-light"><?php echo $row['brandName']; ?></h2>
                        </div>
                    </a>
                </div>



                <?php
                    }

                ?>

            </div>

            <?php
                }else{

            ?>

            <div class="card-body">
                <div class="alert alert-light" role="alert" style="font-size:25px">
                    You did not add any products.
                </div>
            </div>



            <?php
                }    
            ?>


        </div>   

        <!-- Footer -->
        <footer class="page-footer   bg-light text-dark  " style="background-color: c4c4c4; margin-top:130px ">
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
        <script type="text/javascript">
            
            $(document).ready(function(){
                $("#search").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#brands #brandslist").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
            
        </script>
    </body>
</html>