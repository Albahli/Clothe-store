<?php
session_start();

$userExist = false;

if(isset($_SESSION['login_user']))
{
    $loggedUser = $_SESSION['login_user'];

    if(isset($_SESSION['user_type'])){

        $userType = $_SESSION['user_type']; // user type : customer , designer
        $userExist = true;
    }
}


if(!isset($_GET['Product']))
{    
    echo "This page is not available";
}

$productID = $_GET['Product'];

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

//Query -> product infromation
$productID = $_GET['Product'];
$productDesignerID;
$productType;
$productName;
$productPrice;
$productGender;
$productSize;
$productImage;
$productQuantity;
$productTotalRate;

//Product's Info
$sql = "SELECT * FROM Product WHERE productID=".$productID.";";
$result = mysqli_query($conn,$sql);
$resultCheck = mysqli_num_rows($result);

if($resultCheck > 0)
{
    while($row = mysqli_fetch_assoc($result))
    {
        $productDesignerID = $row['productDesignerID'];
        $productType = $row['productType'];
        $productName = $row['productName'];
        $productPrice = $row['productPrice'];
        $productGender = $row['productGender'];
        $productSize = $row['productSize'];
        $productImage = $row['productImage'];
        $productQuantity = $row['productQuantity'];
        $productTotalRate = $row['productTotalRate'];
    }
}
else
{
    echo "<div class='alert alert-warning p-4 text-center' role='alert' style='margin-top:20px; '> The requested page is not available. 
        <a href=home.php>Home page</a>
        </div>";
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <script src="https://kit.fontawesome.com/a5f9aa2fa3.js" crossorigin="anonymous"></script>
        <style>
            *
            {
                font-family: sans-serif;    
            }

            star-rating
            {
                font-size: 0;
            }
            .star-rating__wrap
            {
                display: inline-block;
                font-size: 1rem;
            }
            .star-rating__wrap:after
            {
                content: "";
                display: table;
                clear: both;
            }
            .star-rating__ico
            {
                float: right;
                padding-left: 2px;
                cursor: pointer;
                color: #333333;
            }
            .star-rating__ico:last-child
            {
                padding-left: 0;
            }
            .star-rating__input
            {
                display: none;
            }
            .star-rating__ico:hover:before,
            .star-rating__ico:hover ~ .star-rating__ico:before,
            .star-rating__input:checked ~ .star-rating__ico:before
            {
                content: "\f005";
                font-weight: 900;
            }
        </style>

        <title><?php echo $productName; ?></title>


    </head>
    <body class="font-weight-light">
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
}
                    else if($userExist && $userType='designer')
                    {

                        echo "<li class='nav-item   '>
                                    <a class='nav-link ' href='designerProfile.php'><span class='fas fa-user'></span> " .$_SESSION['login_user']. "</a>
                                  </li>

                                 <li class='nav-item '>
                                    <a class='nav-link' href='designer.php'><span class='fas fa-box'></span> My Products</a>
                                  </li>

                                <li class='nav-item '>
                                    <a class='nav-link' href='logout.php'><span class='fas fa-sign-out-alt'></span> Logout</a>
                                  </li>";
                    }
                    else
                    {
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
        <div class="container pt-4">
            <div class="row">
                <div class="col-md-6">
                    <img class="flex border img-fluid rounded" id="productImage" src="<?php echo $productImage ?>" width="600px" height="500px">
                    <?php
    if(isset($userType) && $userType=='designer')
    {
        $designerAuthorized = false;
        $sql = "SELECT * FROM Designer WHERE userName='".$loggedUser."';";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
        $designerIDCheck;

        if($resultCheck > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $designerIDCheck = $row['designerID'];
            }
        }

        if($designerIDCheck == $productDesignerID)
        {
            $designerAuthorized = true;
            echo "<button type='button' class='btn btn-info btn-block mt-2' data-toggle='modal' data-target='.bd-example-modal-lg'>Update Product Info</button>

                                <!-- Button trigger modal -->
                                <button type='button' class='btn btn-danger btn-block mt-2' data-toggle='modal' data-target='#exampleModal'>
                                  Delete Product
                                </button>

                                <!-- Modal -->
                                <div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>Delete Product</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <form method='post' action='deleteProduct.php'>
                                          <div class='modal-body'>
                                            Are you sure you want to delete this product ?
                                            <input type='text' value='".$productID."' name='productID' hidden>
                                          </div>
                                          <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                            <button type='submit' class='btn btn-danger'>Delete</button>
                                          </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                                <hr>
                                ";
        }
    }
                    ?>
                </div>
                <div class="col-md-6 text-center">
                    <?php 
                    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                    if (strpos($url, "Cart=AddedToCart") == true){

                        echo "<div class='alert alert-success' role='alert' style='margin-top:20px;'>Item Added to Cart !</div>";
                    }
                    else if(strpos($url, "User=NotRegisterd") == true){

                        echo "<div class='alert alert-warning' role='alert' style='margin-top:20px;'>You have to <a href='login.php' class='alert-link'>login</a> to add products in your cart</div>";
                    }
                    ?>
                    <form method="post" action="addToCart.php">
                        <div class="row">
                            <div class="col-sm p-1"><h3 class="text-muted font-weight-light p-2"><?php echo $productName; ?></h3>
                                <input type="text" value="<?php echo $productID;?>" name="productID" hidden>
                                <input type="text" value="<?php if(isset($loggedUser)){ echo $_SESSION['customerID'];} ?>" name="customerID" hidden>
                                <span><hr></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm align-self-start">
                                <p>Size</p> <!--Error because <h4>  inside <p> tag -->
                                <div class="btn-group btn-group-toggle flex-wrap" data-toggle="buttons">
                                    <?php
                                    $size = explode (",", $productSize);
                                    foreach($size as $size)
                                    {
                                        echo "<label class='btn btn-outline-info rounded-0'><input type='radio' name='productSize' autocomplete='off' value=".$size." required>".$size."</label>";    
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 mr-auto ml-auto">
                            <div class="form-group col-sm">
                                <label>Quantity</label>
                                <select class="form-control" name="productQuantity" required>
                                    <?php for($i=1 ; $i<=$productQuantity; $i++)
{
    echo "<option value=".$i.">".$i."</option>";
}
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm">
                                <?php 
                                if($productQuantity>0)
                                {
                                    echo "<h6 class='fas fa-check-circle' style='color:green'> <span>In Stock</span></h6>";
                                }else{  
                                    echo "<h6 class='fas fa-exclamation-circle' style='color:red'> <span>Out of Stock</span></h6>";
                                }

                                echo "<h3 class='text-dark font-weight-bolder m-auto'> ".$productPrice." SAR</h3>";
                                ?>
                                <input type="text" value="<?php echo $productPrice; ?>" name="productPrice" hidden>
                            </div>
                            <?php
                            if(isset($userType) && $userType=='customer'){

                                if($productQuantity>0)
                                {
                                    $sqlCustomer= "SELECT * FROM Cart WHERE customerID='".$_SESSION['customerID']."' AND productID=".$productID.";";
                                    $resultCustomer= mysqli_query($conn,$sqlCustomer);
                                    $resultCustomerCheck= mysqli_num_rows($resultCustomer);

                                    if($resultCustomerCheck>0)
                                    {
                                        echo "<div class='alert alert-secondary w-100 mt-2 ' role='alert'>This product is already in your cart.</div>";
                                    }
                                    else
                                    {
                                        echo "<button type='submit' class='btn btn-info btn-block mt-2'><i class='fas fa-shopping-cart'>&nbsp;</i> Add to Cart</button>";
                                    }
                                }
                                else
                                {    
                                    echo "<button type='submit' disabled class='btn btn-info btn-block mt-2'><i class='fas fa-shopping-cart'>&nbsp;</i> Add to Cart</button>"; 
                                }
                            }else if(!isset($userType)){

                                if($productQuantity>0)
                                    echo "<button type='submit' class='btn btn-info btn-block mt-2'><i class='fas fa-shopping-cart'>&nbsp;</i> Add to Cart</button>";

                                else echo "<button type='submit' disabled class='btn btn-info btn-block mt-2'><i class='fas fa-shopping-cart'>&nbsp;</i> Add to Cart</button>"; 
                            }?>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Large modal -->
        <div class="modal fade bd-example-modal-lg" id="updateProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Update Product Info</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="updateProduct.php" enctype="multipart/form-data" method="post" class="container">

                        <?php      
                        $showMsgModal = false;

                        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                        if(strpos($url, "product=Added") == true){

                            echo "<div class='alert alert-success' role='alert' style='margin-top:20px; '> Product Added succesfully. </div>";

                            $showMsgModal = true;

                        }else if (strpos($url, "file=formatNotSupported") == true){

                            echo "<div class='alert alert-danger' role='alert' style='margin-top:20px;'>Image format must be one of those '.png' or '.jpeg' or '.jpg'.</div>";
                            $showMsgModal = true;
                        }else if (strpos($url, "file=error") == true){

                            echo "<div class='alert alert-danger' role='alert' style='margin-top:20px;'>There is an error with image.</div>";
                            $showMsgModal = true; 
                        }else if (strpos($url, "productSize=NotChosen") == true){

                            echo "<div class='alert alert-danger' role='alert' style='margin-top:20px;'>You have to select at least one size in the 'Product Size' field.</div>";
                            $showMsgModal = true; 
                        }


                        ?>

                        <div class="form-group">
                            <p class=" text-danger mt-1 font-weight-bold">Fill only the fields that needs to be updated.</p>
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="">
                            <input type="text" name="productID" value="<?php echo $productID ;?>" hidden>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="productGender">Product Gender</label>
                                <select id="productGender" class="form-control" name="productGender">
                                    <option value="none"></option>
                                    <option value="m">Male</option>
                                    <option value="f">Female</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="productType">Product Type</label>
                                <select id="productType" class="form-control" name="productType" onload="changeSizes(this.id)" disabled>
                                    <option value="<?php echo $productType; ?>"><?php echo $productType; ?></option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="productSize">Quantity</label>&nbsp;
                                <small class="text-muted" style="font-size:9px">Set quantity to 0 if the product is out of stock.</small>
                                <input type="number" min="0" max="100" class="form-control" name="quantity">
                            </div>
                        </div>
                        <label id="" for="productSize">Product Size</label>
                        <div class="form-row card">
                            <div class="checkbox-inline card-body" id="productSize" >
                                <?php
                                if($productType=="Footwear")
                                {
                                    echo "<input type='checkbox' value='36' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>36</label>
                                             <br>
                                             <input type='checkbox' value='37' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>37</label>
                                             <br>
                                             <input type='checkbox' value='38' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>38</label>
                                             <br>
                                             <input type='checkbox' value='39' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>39</label>
                                             <br>
                                             <input type='checkbox' value='40' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>40</label>
                                             <br>
                                             <input type='checkbox' value='41' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>41</label>
                                             <br>
                                             <input type='checkbox' value='42' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>42</label>
                                             <br>
                                             <input type='checkbox' value='43' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>43</label>
                                             <br>
                                             <input type='checkbox' value='44' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>44</label>
                                             <br>
                                             <input type='checkbox' value='45' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>45</label>
                                             <br>
                                             <input type='checkbox' value='46' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>46</label>
                                             <br>
                                             ";
                                }else if($productType=='Glasses' || $productType=='Sun Glasses')
                                {
                                    echo "<input type='checkbox' value='49mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>49mm</label>
                                             <br>
                                             <input type='checkbox' value='52mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>52mm</label>
                                             <br>
                                             <input type='checkbox' value='54mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>54mm</label>
                                             <br>
                                             <input type='checkbox' value='55mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>55mm</label>
                                             <br>";
                                }else if($productType=='Watches')
                                {
                                    echo "<input type='checkbox' value='26mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>26mm</label>
                                             <br>
                                             <input type='checkbox' value='34mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>34mm</label>
                                             <br>
                                             <input type='checkbox' value='36mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>36mm</label>
                                             <br>
                                             <input type='checkbox' value='39mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>39mm</label>
                                             <br>
                                             <input type='checkbox' value='40mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>40mm</label>
                                             <br>
                                             <input type='checkbox' value='42mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>42mm</label>
                                             <br>
                                             <input type='checkbox' value='44mm' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>44mm</label>
                                             <br>
                                             ";
                                }else
                                {
                                    echo "<input type='checkbox' value='XS' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>XS</label>
                                             <br>
                                             <input type='checkbox' value='Small' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>Small</label>
                                             <br>
                                             <input type='checkbox' value='Medium' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>Medium</label>
                                             <br>
                                             <input type='checkbox' value='Large' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>Large</label>
                                             <br>
                                             <input type='checkbox' value='XL' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>XL</label>
                                             <br>
                                             <input type='checkbox' value='2XL' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>2XL</label>
                                             <br>
                                             <input type='checkbox' value='3XL' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>3XL</label>
                                             <br>
                                             <input type='checkbox' value='4XL' name='productSize[]' class='productSize'>
                                             <span>&nbsp;</span>
                                             <label>4XL</label>
                                             <br>
                                             ";
                                }
                                ?>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Choose Image</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="fileUpdate" name="fileUpdate" >
                                    <label class="custom-file-label" for="fileUpdate">-</label>
                                </div>
                            </div>
                        </div>


                        <label>Price</label>
                        <div class="form-group input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            <input type="number" min="0" class="form-control" name="price" >
                            <div class="input-group-append">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <h2 class="text-muted font-weight-light">Reviews</h2>
            <div class="card">
                <div class="container justify-content-center">
                    <div class="row p-3 mb-2 bg-light text-dark border-bottom">
                        <?php
                        $numOfRates = 0;
                        $customerTotalWeight = 0;
                        $numOf_5_Rates = 0;
                        $numOf_4_Rates = 0;
                        $numOf_3_Rates = 0;
                        $numOf_2_Rates = 0;
                        $numOf_1_Rates = 0;

                        $sql = "SELECT customerRate, COUNT(*) as total FROM RatedProducts WHERE customerRate = 5 AND productID=".$productID.";";
                        $result = mysqli_query($conn,$sql);
                        $resultCheck = mysqli_num_rows($result);

                        if($resultCheck>0){
                            while($row = mysqli_fetch_assoc($result)){

                                if($row['total']==0)
                                    break;

                                $numOf_5_Rates += $row['total'];
                                $customerTotalWeight +=$row['customerRate']; 
                                $numOfRates++;
                            }
                        }

                        $sql = "SELECT customerRate, COUNT(*) as total FROM RatedProducts WHERE customerRate = 4 AND productID=".$productID.";";
                        $result = mysqli_query($conn,$sql);
                        $resultCheck = mysqli_num_rows($result);

                        if($resultCheck>0){
                            while($row = mysqli_fetch_assoc($result)){

                                if($row['total']==0)
                                    break;

                                $numOf_4_Rates += $row['total'];
                                $customerTotalWeight +=$row['customerRate']; 
                                $numOfRates++;
                            }
                        }

                        $sql = "SELECT customerRate, COUNT(*) as total FROM RatedProducts WHERE customerRate = 3 AND productID=".$productID.";";
                        $result = mysqli_query($conn,$sql);
                        $resultCheck = mysqli_num_rows($result);

                        if($resultCheck>0){
                            while($row = mysqli_fetch_assoc($result)){

                                if($row['total']==0)
                                    break;

                                $numOf_3_Rates += $row['total'];
                                $customerTotalWeight +=$row['customerRate']; 
                                $numOfRates++;
                            }
                        }

                        $sql = "SELECT customerRate, COUNT(*) as total FROM RatedProducts WHERE customerRate = 2 AND productID=".$productID.";";
                        $result = mysqli_query($conn,$sql);
                        $resultCheck = mysqli_num_rows($result);

                        if($resultCheck>0){
                            while($row = mysqli_fetch_assoc($result)){

                                if($row['total']==0)
                                    break;
                                $numOf_2_Rates += $row['total'];
                                $customerTotalWeight +=$row['customerRate']; 
                                $numOfRates++;
                            }
                        }

                        $sql = "SELECT customerRate, COUNT(*) as total FROM RatedProducts WHERE customerRate = 1 AND productID=".$productID.";";
                        $result = mysqli_query($conn,$sql);
                        $resultCheck = mysqli_num_rows($result);

                        if($resultCheck>0){
                            while($row = mysqli_fetch_assoc($result)){

                                if($row['total']==0)
                                    break;

                                $numOf_1_Rates += $row['total'];
                                $customerTotalWeight +=$row['customerRate']; 
                                $numOfRates++;
                            }
                        }

                        if($numOfRates==0)
                            $numOfRates=-1;

                        $productTotalRate = $customerTotalWeight/$numOfRates; 
                        ?>
                        <div class="col-6 pt-3 text-center mt-5">
                            <h1 class="text-info font-weight-light" style="font-size:30px">
                                <?php echo round($productTotalRate,1) ; ?>
                                <span class="text-dark" style="font-size:20px">/ 5</span>
                            </h1>
                            <p class="fas fa-user-alt text-muted">&nbsp;
                                <span class="font-weight-light">
                                    <?php
                                    if($numOfRates==-1)
                                        echo 0; 
                                    else echo $numOfRates;
                                    ?> rates


                                </span>
                            </p>
                            <br>

                            <?php // review for a 'customer' who bought this product.
                            if(isset($userType) && $userType=='customer')// check if the customer reviewd it or not.
                            {
                                $sqlCart = "SELECT * FROM PurchasedProducts WHERE customerID = '".$_SESSION['customerID']."' AND productID=".$productID.";";
                                $resultCart = mysqli_query($conn,$sqlCart);
                                $resultCartCheck = mysqli_num_rows($resultCart);

                                if($resultCartCheck>0)
                                {
                                    $sql = "SELECT * FROM RatedProducts WHERE customerUserName = '".$loggedUser."' AND productID=".$productID.";";
                                    $result = mysqli_query($conn,$sql);
                                    $resultCheck = mysqli_num_rows($result);

                                    if($resultCheck>0)
                                    {
                                        echo "
                                        <div class='alert alert-secondary w-auto mx-auto' role='alert'>
                                            You have already reviewed this product.
                                        </div>
                                        ";
                                    }

                                    else
                                    {
                                        echo "
                                        <button type='button' class='btn btn-primary btn-sm mt-4' data-toggle='modal' data-target='#reviewModal'>
                                        <i class='fas fa-pen'>&nbsp;</i> Write Review
                                        </button>
                                        ";
                                    }
                                }
                            }
                            ?>  
                            <!-- Modal for review -->
                            <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">New Review</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form method="post" action="writeReview.php" name="writeReview">
                                            <div class="modal-body">


                                                <div class="form-group ">
                                                    <div class="star-rating">
                                                        <div class="star-rating__wrap" style="font-size:30px">
                                                            <input class="star-rating__input" id="star-rating-5" type="radio" name="rating" value="5" required>
                                                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-5" title="5 out of 5 stars"></label>
                                                            <input class="star-rating__input" id="star-rating-4" type="radio" name="rating" value="4" required>
                                                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-4" title="4 out of 5 stars"></label>
                                                            <input class="star-rating__input" id="star-rating-3" type="radio" name="rating" value="3" required>
                                                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-3" title="3 out of 5 stars"></label>
                                                            <input class="star-rating__input" id="star-rating-2" type="radio" name="rating" value="2" required>
                                                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-2" title="2 out of 5 stars"></label>
                                                            <input class="star-rating__input" id="star-rating-1" type="radio" name="rating" value="1" required>
                                                            <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-1" title="1 out of 5 stars"></label>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <input type="text" value="<?php echo $productID;?>" name="productID" hidden>
                                                    <input type="text" value="<?php echo $loggedUser;?>" name="customerUserName" hidden>
                                                    <label class="font-weight-bold float-left">Title</label>
                                                    <input type="text" class="form-control"placeholder="Ex: Great Product." name="title" required>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold float-left">Review</label>
                                                    <textarea class="form-control" rows="3" name="review" required placeholder="-Would you recommend this product?
                                                                                                                                -What are the pros & cons?"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="submit">Send Review</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>        
                        </div>
                        <div class="col-6 pt-3">
                            <span class="float-left">5 Star &nbsp;</span>
                            <div class="progress" style="margin-top:3px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $numOf_5_Rates/$numOfRates*100;?>%" aria-valuenow="50" aria-valuemin="1" aria-valuemax="100"><?php echo round($numOf_5_Rates/$numOfRates*100,1);?>%</div>
                            </div>
                            <br>
                            <span class="float-left">4 Star &nbsp;</span>
                            <div class="progress" style="margin-top:3px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $numOf_4_Rates/$numOfRates*100;?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><?php echo round($numOf_4_Rates/$numOfRates*100,1);?>%</div>
                            </div>
                            <br>
                            <span class="float-left">3 Star &nbsp;</span>
                            <div class="progress" style="margin-top:3px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $numOf_3_Rates/$numOfRates*100;?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><?php echo round($numOf_3_Rates/$numOfRates*100,1);?>%</div>
                            </div>
                            <br>
                            <span class="float-left">2 Star &nbsp;</span>
                            <div class="progress" style="margin-top:3px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $numOf_2_Rates/$numOfRates*100;?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><?php echo round($numOf_2_Rates/$numOfRates*100,1);?>%</div>
                            </div>
                            <br>
                            <span class="float-left">1 Star &nbsp;</span>
                            <div class="progress" style="margin-top:3px">
                                <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $numOf_1_Rates/$numOfRates*100;?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><?php echo round($numOf_1_Rates/$numOfRates*100,1);?>%</div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
                <?php
                //Product's Reviews
                $sql = "SELECT * FROM RatedProducts WHERE productID=".$productID.";";
                $reviewResult = mysqli_query($conn,$sql);
                $reviewResultCheck = mysqli_num_rows($reviewResult);

                if($reviewResultCheck > 0){
                    $i=1;
                    while($row = mysqli_fetch_assoc($reviewResult)){

                        echo "
                                <div class='row p-2'>
                                        <div class='col text-left'>
                                           <h5 class='font-weight-bold d-inline'>".$row['customerUserName']."</h5>
                                           <span class='float-right text-muted'>".$row['reviewDate']."</span>
                                           <div class='m-2'style='color:#333333'>";

                        $customerRate = $row['customerRate'];

                        if($customerRate == null){

                            echo"
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star'></i>";
                        }

                        else if($customerRate < 1){

                            echo" 
                                              <i class='fas fa-star-half-alt'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star''></i>
                                              <i class='far fa-star'></i>";


                        } else if($customerRate >=1 &  $customerRate<1.5) {

                            echo" 
                                              <i class='fas fa-star'></i> 
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star'></i>";

                        }else if($customerRate >=1.5 &  $customerRate<2) {

                            echo" 
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star-half-alt'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star''></i>
                                              <i class='far fa-star'></i>";

                        }else if($customerRate >=2 &  $customerRate<2.5) {

                            echo" 
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='far fa-star'></i>
                                              <i class='far fa-star''></i>
                                              <i class='far fa-star'></i>";

                        }else if($customerRate >=2.5 &  $customerRate<3) {

                            echo" 
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star-half-alt'></i>
                                              <i class='far fa-star''></i>
                                              <i class='far fa-star'></i>";

                        }else if($customerRate >=3 &  $customerRate<3.5) {

                            echo" 
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='far fa-star''></i>
                                              <i class='far fa-star'></i>";

                        }else if($customerRate >=3.5 &  $customerRate<4) {

                            echo" 
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star-half-alt''></i>
                                              <i class='far fa-star'></i>";

                        }else if($customerRate >=4 &  $customerRate<4.5) {

                            echo" 
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='far fa-star'></i>";

                        }else if($customerRate >=4.5 &  $customerRate<5){

                            echo" 
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star-half-alt'></i>";
                        } else if ($customerRate==5){

                            echo" 
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>
                                              <i class='fas fa-star'></i>";
                        }        


                        echo "          <span>&nbsp;</span>
                                            <span class='text-muted font-weight-bold '>".$row['customerReviewTitle']."</span>
                                        </div>
                                            <div class='p-3 mb-2 bg-light text-dark'>".$row['customerReview']."</div>
                                        </div>
                                </div>";

                        if(!empty($row['designerReplay'])){
                            echo "
                                <div class='p-9 ml-4 mr-2 mb-4 border-left border-info rounded-0 rounded-lg'>
                                    <div class='p-3 bg-light text-dark'>
                                        <h6 class='font-weight-bold text-muted'>Designer Response:</h6>
                                        <p>".$row['designerReplay']."</p>
                                    </div>
                                </div>

                                ";
                        }else if( isset($userType) && $userType=='designer' && $designerAuthorized){

                            echo"
                                <div class='accordion mr-4 ml-4 mb-4' id='accordionExample".$i."'>
                                     <div class='card'>
                                        <div class='card-header' id='headingOne".$i."'>
                                          <h2 class='mb-0'>
                                            <button class='btn btn-link' type='button' data-toggle='collapse' data-target='#collapseOne".$i."' aria-expanded='true' aria-controls='collapseOne".$i."'>
                                              Replay
                                            </button>
                                          </h2>
                                        </div>

                                        <div id='collapseOne".$i."' class='collapse p-4' aria-labelledby='headingOne".$i."' data-parent='#accordionExample".$i."'>

                                          <form method='post' action='feedbackToCustomer.php' id='feedbackToCustomer".$i."'>

                                                <div class='form-group p-3'>
                                                    <label for='exampleFormControlTextarea".$i."' class='text-muted'>You cannot edit the feedback after submiting.</label>
                                                    <textarea class='form-control' form='feedbackToCustomer".$i."' name='designerReplay' id='exampleFormControlTextarea".$i."' rows='3' required></textarea>
                                                    <input type='text' hidden name='productID' value=".$productID.">
                                                    <input type='text' hidden name='reviewID' value=".$row['reviewID'].">
                                                    <button type='submit' class='btn btn-primary btn-sm float-left mt-3'>Send Feedback To ".$row['customerUserName']."</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                ";
                        }
                        if($i!=$reviewResultCheck)
                            echo "<hr>";
                        $i++;
                    }
                }else{
                    echo "<h5 class='text-muted font-weight-lighter text-center p-5'>No reviews</h5>";


                } 
                ?>
            </div>
        </div>

        <!-- Footer -->
        <footer class="page-footer  mb-2 bg-light " style="background-color:; margin-top:130px ">
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
                <a href="home.php"> Brands.com</a>
            </div>
        </footer>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script type="text/javascript">
            <?php
            if($showMsgModal)
                echo "    
                $(document).ready(function(){
                $('#updateProduct').modal('show');
                   });";
            ?>
            $('#fileUpdate').on('change',function(){
                //get the file name
                var fileName = $(this).val();
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileName);
            });
        </script>
    </body>
</html>