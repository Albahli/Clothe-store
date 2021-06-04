<?php
session_start();
if(isset($_SESSION['customerID']) && $_SESSION['user_type']=='customer')
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

        <title><?php echo $customer. " | Shopping Cart" ?> </title>
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

            if (strpos($url, "Cart=Purchased") == true)
            {
                echo "<div class='alert alert-success' role='alert' style='margin-top:20px;'>You have set your order successfully !</div>";
            }
            ?>
        </div>
        <?php 

        $sqlCart= "SELECT * FROM Product , Cart  WHERE customerID=".$_SESSION['customerID']."  AND Cart.productID=Product.productID;";
        $resultCart = mysqli_query($conn,$sqlCart);
        $resultCartCheck= mysqli_num_rows($resultCart);

        if($resultCartCheck>0)
        {
        ?>
        <div class="container  mt-5 text-center">
            <div class="card text-center mb-5">
                <h5 class="card-header text-left">Shopping Cart</h5>
                <div class="card-body table-responsive">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col"></th>
                                <th scope="col">Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Size</th>
                                <th scope="col">Price</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php

            $i=1;
            $totalPrice = 0;
            $productID;
            $qunatity = 1;
            while($row = mysqli_fetch_assoc($resultCart))
            {
                $productID = $row['productID'];
                $qunatity = $row['productQuantity'];
                
                echo"

                                        <tr>
                                            <th scope='row'>".$i++."</th>                                          
                                            <td>
                                                <a href='product.php?Product=".$row['productID']."'>
                                                    <img src=".$row['productImage']." class='flex border rounded' width='120' height='100'>
                                                </a>
                                            </td>
                                            <td>
                                                <a href='product.php?Product=".$row['productID']."' class='text-info'>".$row['productName']."</a>
                                            </td>
                                            <td>".$row['productQuantity']."</td>
                                            <td>".$row['productSize']."</td>
                                            <td>".$row['productPrice']."</td>
                                            <td>
                                                <form action='deleteFromCart.php' method='post'>
                                                    <input type='text' value=".$row['productID']." name='productID' hidden>
                                                    <input type='text' value=".$_SESSION['customerID']." name='customerID' hidden>
                                                    <button type='submit' class='btn btn-danger'>
                                                        <span class='far fa-window-close'></span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        ";
                $totalPrice += $row['productPrice'];
            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <?php
            $shippingAddress;
            $city;
            $phoneNumber;
            $sqlCustomer= "SELECT * FROM Customer WHERE customerID='".$_SESSION['customerID']."';";
            $resultCustomer= mysqli_query($conn,$sqlCustomer);
            $resultCustomerCheck= mysqli_num_rows($resultCustomer);

            if($resultCustomerCheck>0)
            {
                while($row=mysqli_fetch_assoc($resultCustomer))
                {
                    $shippingAddress = $row['address'];
                    $city = $row['city'];
                    $phoneNumber = $row['phoneNumber'];
                }
            }
                ?>
                <h5 class="card-header text-left">Checkout</h5>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm text-left p-2">
                                <h5 class=" font-weight-bolder text-dark ">Shipping Info:</h5>
                                <br>
                                <h6 class=" font-weight-lighter text-muted font-italic">City: <?php echo $city ;?></h6>
                                <h6 class=" font-weight-lighter text-muted font-italic">Shipping Address: <?php echo $shippingAddress ;?></h6>
                                <h6 class=" font-weight-lighter text-muted font-italic">Phone Number: <?php echo $phoneNumber ;?></h6>
                            </div>
                            <div class="col-sm text-left p-2">
                                <h5 class=" font-weight-bolder text-dark ">Pricing Info:</h5>
                                <br>
                                <h6 class=" font-weight-lighter text-muted font-italic">Price Tax-Excluded: <?php echo $totalPrice = $totalPrice * $qunatity; ?> SAR</h6>
                                <h6 class=" font-weight-lighter text-muted font-italic">Tax: <?php $tax = $totalPrice*0.05;
            echo $tax; ?> SAR</h6>
                                <h6 class=" font-weight-lighter text-muted font-italic">Price Tax-Included: <?php $totalPrice = $totalPrice + $tax;
            echo $totalPrice; ?> SAR</h6>
                                <h6 class=" font-weight-lighter text-muted font-italic">Shipping Fee: 10 SAR</h6>
                                <h6 class=" font-weight-bolder text-danger font-italic">Grand Total: <?php echo $totalPrice+10 ;?> SAR</h6>
                            </div>
                            <div class="col-md">
                                <div class="card p-3">
                                    <h5 class="font-weight-bolder text-dark ">Credit Card Info:</h5>
                                    <br>
                                    <form action="purchase.php" method="post">
                                        <div class="row">
                                            <div class="col">
                                                <label for="cardholdername">Cardholder Name</label>
                                                <input id="cardholdername" type="text" class="form-control" placeholder="Fazal Amin">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mt-2">
                                                <label for="cardnumber">Card Number</label>
                                                <input id="cardnumber" type="text" class="form-control" placeholder="1234 5678 9000 0000">
                                            </div>
                                        </div>
                                        <label class="mt-2"> Expiration</label>
                                        <br>
                                        <div class="form-row">
                                            <div class="form-group col">
                                                <select id="inputState" class="form-control">
                                                    <option selected>Month</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>
                                                    <option>7</option>
                                                    <option>8</option>
                                                    <option>9</option>
                                                    <option>10</option>
                                                    <option>11</option>
                                                    <option>12</option>
                                                </select>
                                            </div>
                                            <div class="form-group col">
                                                <select id="inputState" class="form-control">
                                                    <option selected>Year</option>
                                                    <option>2020</option>
                                                    <option>2021</option>
                                                    <option>2022</option>
                                                    <option>2023</option>
                                                    <option>2024</option>
                                                    <option>2025</option>
                                                    <option>2026</option>
                                                    <option>2027</option>
                                                    <option>2028</option>
                                                    <option>2029</option>
                                                    <option>2030</option>
                                                    <option>2031</option>
                                                    <option>2032</option>
                                                    <option>2033</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <label for="CCV">CCV</label>
                                                <input type="text" class="form-control" id="CCV" min="1" max="3">
                                            </div>
                                            <div class="col">
                                                <img src="photos/paymentMethod1.png" class="flex form-inline mt-2" width="150" height="60">
                                            </div>
                                        </div>
                                        <p class="font-weight-bold text-danger mt-4">Total: <?php echo $totalPrice+10 ;?> SAR</p>
                                        <input type="text" value="<?php echo $_SESSION['customerID']; ?>" name='customerID' required hidden>
                                        <button type="submit" class="btn btn-primary btn-block mt-4" name="submit">Purchase</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        else
        {
            echo "<h3 class='card mt-5 mb-auto text-center font-weight-lighter text-muted' role='alert'>There is no items in your cart </h3>";
        }
            ?>
        </div>
        <!-- Footer -->
        <footer class="page-footer  bg-light " style="background-color:; margin-top:130px ">
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