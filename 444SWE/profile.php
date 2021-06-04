<?php
session_start();
if(isset($_SESSION['login_user']) && $_SESSION['user_type']=='customer')
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
                        <a class='nav-link' href='profile.php'><span class='fas fa-user'></span> <?php echo $customer;?></a>
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

            if (strpos($url, "Profile=Updated") == true)
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
            <div class=" text-center p-3 mt-4 mb-4 ">
                <div class="row">
                    <div class="col text-left">
                    </div>
                </div>
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                        <a class="nav-item nav-link " id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Order History</a>
                    </div>
                </nav>
                <div class="tab-content border rounded" id="nav-tabContent">
                    <div class="tab-pane fade " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="text-left p-3 text-muted">
                            <p>- Here you can see all the items that you have purchased.</p>
                            <p>- Since you have already purchased the an item, you can review and give your feedback about this item.</p>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Brand / Designer</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Purchase Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sqlCustomerPurchasedProducts = "SELECT DISTINCT Product.productID as id, Product.productName, purchaseDate as pd, brandName as brand, designerID as brandID
                                FROM PurchasedProducts as pp, Product, Designer as d
                                WHERE customerID=".$_SESSION['customerID']." AND pp.productID = Product.productID
                                AND Product.productDesignerID = d.designerID
                                ORDER BY pd;";
                                $resultCustomerPurchasedProducts = mysqli_query($conn,$sqlCustomerPurchasedProducts);
                                $resultCustomerPurchasedProductsCheck = mysqli_num_rows($resultCustomerPurchasedProducts);

                                if($resultCustomerPurchasedProductsCheck > 0)
                                {
                                    $i=1;

                                    while($row = mysqli_fetch_assoc($resultCustomerPurchasedProducts))
                                    {



                                        echo"
                                            <tr>
                                                <th scope='row'>".$i++."</th>
                                                    <td>
                                                        <a href='designerBrand.php?id=".$row['brandID']."' class='text-info'>".$row['brand']."</a>
                                                    </td>
                                                    <td>
                                                        <a href='product.php?Product=".$row['id']."' class='text-info'>".$row['productName']."</a>
                                                    </td>
                                                <td>".$row['pd']."</td>       
                                            </tr>
                                            ";
                                    }
                                }
                                else
                                {
                                    echo "No products";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="card-body bg-light text-left">
                            <?php
                            $sqlCustomer = "SELECT * FROM Customer WHERE userName='".$customer."';";
                            $resultCustomer = mysqli_query($conn,$sqlCustomer);
                            $resultCustomerCheck = mysqli_num_rows($resultCustomer);

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
                                }
                            }
                            ?>
                            <hr>
                            <p class="text-danger font-weight-bold float-left">Fill only the fields thats need to be updated.</p>
                            <form class="p-3" action="updateProfile.php" method="post">
                                <input type="text" name="customerUsername" value="<?php echo $customer; ?>" hidden>
                                <div class="form-row mt-5">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationDefault02">Email</label>
                                        <input type="email" class="form-control" id="validationDefault02" name="email" placeholder="example@example.com">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationDefault02">Phone Number</label>
                                        <input type="number" min="0" pattern="" class="form-control" name="phoneNumber" id="validationDefault02" placeholder="0599999999">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationDefault03">City</label>
                                        <input type="text" class="form-control" id="validationDefault03" name="city" placeholder="Riyadh" >
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="validationDefault03">Address</label>
                                        <input type="text" class="form-control" id="validationDefault03" name="address" placeholder="Almalqa, 206 street 12783" >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationDefault04">Password</label>
                                        <input type="password" class="form-control" name="password" id="validationDefault04" placeholder="••••••••••" >
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="validationDefault05">Confirm Password</label>
                                        <input type="password" class="form-control" id="validationDefault05" placeholder="••••••••••">
                                    </div>
                                </div>
                                <button class="btn btn-primary mt-3" type="submit">Save Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <footer class="page-footer  mb-2 bg-light text-dark " style="background-color:; margin-top:130px ">
            <!-- Footer Elements -->
            <hr>
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
    </body>