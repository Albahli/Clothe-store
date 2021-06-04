<?php
session_start();
if(isset($_SESSION['login_user']) && $_SESSION['login_user']=='customer')
{

    $customer = $_SESSION['login_user'];     



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

    $sqlCustomer = "SELECT * FROM Customer WHERE userName='".$customer."';";
    $resultCustomer = mysqli_query($conn,$sqlCustomer);
    $resultCustomerCheck = mysqli_num_rows($resultCustomer);
}
else
{
    header("Location: login.php");
}


?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--  <meta name="viewport" content="width=600">

<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/a5f9aa2fa3.js" crossorigin="anonymous"></script>
        <style></style>

        <title><?php echo $customer. " | Profile" ?> </title>
    </head>

    <body class="font-weight-light" style="font-family: sans-serif">
        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
            <a class="navbar-brand" href="home.php"><img src="logo1.png" style="height:40px; width:40px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
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
                    <li class=' nav-item '>
                        <a class='nav-link' href='profile.php'><span class='fas fa-user'></span><?php echo $customer;?></a>
                    </li>

                    <li class='nav-item'>
                        <a class='nav-link' href='cart.php'><span class='fas fa-shopping-cart'></span> Shopping Cart</a>
                    </li>

                    <li class='nav-item'>
                        <a class='nav-link' href='logout.php'><span class='fas fa-sign-out-alt'></span> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container text-center">
            <?php
            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if(strpos($url, "file=formatNotSupported") == true)
            {
                echo "<div class='alert alert-danger' role='alert' style='margin-top:20px;'>Brand Logo format must be .PNG or .JPEG or .JPG </div>";
            }
            else if (strpos($url, "Profile=Updated") == true)
            {
                echo "<div class='alert alert-success' role='alert' style='margin-top:20px;'>Profile updated successfuly</div>";
            }
            else if(strpos($url, "Profile=NotUpdated") == true)
            {
                echo "<div class='alert alert-warning' role='alert' style='margin-top:20px;'>You have to update at least one of the fields.</div>";
            }
            ?>
        </div>
        <div class="container  mt-5 text-center">
            <div class="border rounded text-center p-3 mt-4 mb-4 ">
                <div class="row">
                    <div class="col text-left">
                        <?php
                        if($resultCustomerCheck>0)
                        {
                            while($row = mysqli_fetch_assoc($resultCustomer))
                            {
                                echo"
                                        <p>Username: <span class='text-info'>".$row['userName']."</span></p>
                                        <p>Email: <span class='text-info'>".$row['email']."</span></p>
                                        <p>City: <span class='text-info'>".$row['city']."</span></p>
                                        <p>Address: <span class='text-info'>".$row['address']."</span></p>
                                        <p>Phone number: <span class='text-info'>".$row['phoneNumber']."</span></p>
                                        ";

                                $logoFile = $row['brandLogo'];
                            }
                        }
                        ?>
                    </div>
                    <div class="col">
                        <?php
                        if(empty($logoFile))
                        {
                            echo "<img class='flex border img-fluid rounded' width='300' height='300'><p class=''>You did not set logo for your brand.</p>";
                        }
                        else
                        {
                            echo "<img class='flex border img-fluid rounded' src=".$logoFile." width='300' height='300'>
                            <p class=''>Brand logo</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="accordion p-3" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Update profile info
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body bg-light">
                                <hr>
                                <p class="text-danger font-weight-bold float-left">Fill only the fields thats need to be updated.</p>
                                <form class="p-3" action="updateDesignerProfile.php" enctype="multipart/form-data" method="post">
                                    <input type="text" name="designerID" value="<?php echo $designerID; ?>" hidden>
                                    <div class="form-row mt-5">
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault01">Brand Name</label>
                                            <input type="text" class="form-control" id="validationDefault01" name="brandName" placeholder="Nike">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault02">Email</label>
                                            <input type="email" class="form-control" id="validationDefault02" name="email" placeholder="example@example.com">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="validationDefault02">Phone Number</label>
                                            <input type="number" min="0" pattern="" class="form-control" name="phoneNumber" id="validationDefault02" placeholder="0599999999">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="validationDefault03">City</label>
                                            <input type="text" class="form-control" id="validationDefault03" name="city" placeholder="Riyadh" >
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationDefault04">Password</label>
                                            <input type="password" class="form-control" name="password" id="validationDefault04" placeholder="••••••••••" >
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="validationDefault05">Confirm Password</label>
                                            <input type="password" class="form-control" id="validationDefault05" placeholder="••••••••••">
                                        </div>
                                    </div>

                                    <div class="form-row mt-3">
                                        <label for="logoInput " class="m-auto ">Logo</label>
                                        <div class="custom-file mt-3" id="logoInput">
                                            <input type="file" class="custom-file-input form-control" id="customFile" name="fileLogo">
                                            <label class="custom-file-label" for="customFile" data-browse="Upload logo">-</label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-3" type="submit">Save Profile</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="page-footer p-3 mb-2 bg-light text-dark font-small cyan darken-3" style="background-color:; margin-top:130px ">
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
                <a href="home.php"> Brands.com</a>
            </div>
        </footer>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script type="text/javascript">
            $('#customFile').on('change',function(){
                //get the file name
                var fileName = $(this).val();
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileName);
            });
        </script>
    </body>