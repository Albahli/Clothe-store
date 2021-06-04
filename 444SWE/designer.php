<?php
session_start();

if(isset($_SESSION['login_user']) )
{

    $loggedUser = $_SESSION['login_user'];

    if(isset($_SESSION['user_type']))
    {

        $userType = $_SESSION['user_type']; // user type : customer , designer

        if($userType=='designer')
        {
            $designer = $_SESSION['login_user'];     
            $designerID = $_SESSION['designerID'];
            $brandName = $_SESSION['brandName'];
        }
        else
        {
            header("Location: login.php");
        }

        $userExist = true;

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


    $sql = "SELECT * FROM Product WHERE productDesignerID=".$designerID.";";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);


    $sqlDesigner = "SELECT * FROM Designer WHERE designerID=".$designerID.";";
    $resultDesigner = mysqli_query($conn,$sqlDesigner);
    $resultDesignerCheck = mysqli_num_rows($resultDesigner);

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


        <style>
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




        <title><?php echo $brandName. " | Products" ?> </title>
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

                    <li class='nav-item '>
                        <a class='nav-link ' href='designerProfile.php'><span class='fas fa-user'></span> <?php echo $_SESSION['login_user'];?></a>
                    </li>

                    <li class='nav-item'>
                        <a class='nav-link' href='designer.php'><span class='fas fa-box'></span> My Products</a>
                    </li>

                    <li class='nav-item'>
                        <a class='nav-link' href='logout.php'><span class='fas fa-sign-out-alt'></span> Logout</a>
                    </li>


                </ul>


            </div>
        </nav>

        <div class="container ">

            <h1 class="text-center text-muted p-5 font-weight-light"><?php echo $brandName; ?></h1>  



            <?php

            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if(strpos($url, "product=Deleted") == true){

                echo "<div class='alert alert-success p-2 text-center' role='alert' style='margin-top:20px; '> Product Deleted succesfully. </div>";

                $showMsgModal = true;

            }

            ?>






            <!-- Large modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Add New Product</button>
            <div class="modal fade bd-example-modal-lg" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

                <div class="modal-dialog modal-lg">


                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Add New Product</h2>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div> 

                        <form action="addProduct.php" enctype="multipart/form-data" method="post" class="container">

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
                                <label for="productName">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="productName" placeholder="" required>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="productGender">Product Gender</label>
                                    <select id="productGender" class="form-control" name="productGender" required>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                        <option value="both">Both</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="productType">Product Type</label>
                                    <select id="productType" class="form-control" name="productType" onchange="changeSizes(this.id)" required>

                                        <option></option>
                                        <option value="Headgear">Headgear</option>
                                        <option value="Scarves">Scarves</option>
                                        <option value="Glasses">Glasses</option>
                                        <option value="Sun Glasses">Sun Glasses</option>
                                        <option value="Tops">Tops</option>
                                        <option value="Jackets/Coats">Jackets/Coats</option>
                                        <option value="Belts">Belts</option>
                                        <option value="Full Body Wear">Full Body Wear</option>
                                        <option value="Watches">Watches</option>
                                        <option value="Gloves">Gloves</option>
                                        <option value="Bottoms">Bottoms</option>
                                        <option value="Innerwear">Innerwear</option>
                                        <option value="Socks">Socks</option>
                                        <option value="Footwear">Footwear</option>


                                    </select>
                                </div>




                                <div class="col-md-4">
                                    <label for="productSize">Quantity</label>
                                    <input type="number" min="0" max="100" class="form-control" name="quantity" required>

                                </div>

                            </div>



                            <label id="" for="productSize">Product Size</label>
                            <div class="form-row card"  >


                                <div class="checkbox-inline card-body" id="productSize" >

                                </div>
                            </div>
                            <br>

                            <div class="form-row">
                                <div class="form-group">
                                    <label>Choose Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file" >
                                        <label class="custom-file-label" for="file">-</label>
                                    </div>
                                </div>
                            </div>


                            <label>Price</label>
                            <div class="form-group input-group mb-3">


                                <div class="input-group-prepend">
                                    <span class="input-group-text">SAR</span>
                                </div>
                                <input type="number" min="0" class="form-control" name="price"  required>
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>







                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
                            </div>



                        </form>


                    </div>
                </div>
            </div>








        </div> <!-- End of container -->

        <hr>
        <div class="container mx-auto " >
            <div class="row d-flex flex-row justify-content-around text-center">
                <?php 

                if($resultCheck > 0){          

                    while($row = mysqli_fetch_assoc($result)){

                ?>

                <div class="<?php echo $row['productType'] ." ". $row['productGender'];?> font-weight-light " style="margin-top:25px">
                    <a class="text-muted " href="product.php?<?php echo "Product=".$row['productID']; ?>" style="text-decoration: none;" ><div class="border  align-items-center product-card rounded" style="background-color:#f2f2f2; ">

                        <img class="flex text-center rounded-top" src="<?php echo $row['productImage']; ?>" style="vertical-align: middle;"  width="300px;" height="230px">



                        <h2 class="mt-2 text-dark font-weight-light"><?php echo $row['productName']; ?></h2>
                        <p><?php echo $row['productPrice']." SAR"; ?></p>

                        <?php
                        $productRate = $row['productTotalRate'];

                        echo "<div class='mb-1'style='color:#333333'>";

                        if($productRate == null){

                            echo"
      <i class='far fa-star'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star'></i>";
                        }

                        else if($productRate < 1){

                            echo" 
      <i class='fas fa-star-half-alt'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star''></i>
      <i class='far fa-star'></i>";


                        } else if($productRate >=1 &  $productRate<1.5) {

                            echo" 
      <i class='fas fa-star'></i> 
      <i class='far fa-star'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star'></i>";

                        }else if($productRate >=1.5 &  $productRate<2) {

                            echo" 
      <i class='fas fa-star'></i>
      <i class='fas fa-star-half-alt'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star''></i>
      <i class='far fa-star'></i>";

                        }else if($productRate >=2 &  $productRate<2.5) {

                            echo" 
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='far fa-star'></i>
      <i class='far fa-star''></i>
      <i class='far fa-star'></i>";

                        }else if($productRate >=2.5 &  $productRate<3) {

                            echo" 
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star-half-alt'></i>
      <i class='far fa-star''></i>
      <i class='far fa-star'></i>";

                        }else if($productRate >=3 &  $productRate<3.5) {

                            echo" 
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='far fa-star''></i>
      <i class='far fa-star'></i>";

                        }else if($productRate >=3.5 &  $productRate<4) {

                            echo" 
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star-half-alt''></i>
      <i class='far fa-star'></i>";

                        }else if($productRate >=4 &  $productRate<4.5) {

                            echo" 
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas far fa-star'></i>";

                        }else if($productRate >=4.5 &  $productRate<5){

                            echo" 
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star-half-alt'></i>";
                        } else if ($productRate==5){

                            echo" 
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>
      <i class='fas fa-star'></i>";
                        }

                        echo "</div>";
                        ?>

                        </div></a>
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
        <footer class="page-footer p-3 mb-2 bg-light text-dark font-small cyan darken-3" style="background-color: c4c4c4; margin-top:130px ">

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

        <?php

        if($showMsgModal)
            echo "    
        $(document).ready(function(){
		$('#addProduct').modal('show');
	       });";

        ?>

        $('#file').on('change',function(){
            //get the file name
            var fileName = $(this).val();
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        });




        // XS SMALL MEDUIM LARGE ... 4XL
        function changeSizes(id){

            let productType = document.getElementById(id);



            $('#productSize').find('input').remove().end();
            $('#productSize').find('label').remove().end();
            $('#productSize').find('span').remove().end();
            $('#productSize').find('br').remove().end();





            if(productType.value==''){
                return;
            }
            if(productType.value=='Sun Glasses' || productType.value=='Glasses'){



                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '49mm',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '49mm',

                }));




                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '52mm',
                    name: 'productSize[]',
                    class: 'productSize',
                }));


                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '52mm ',

                }));






                $('#productSize').append($('<br>', { 
                }));


                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '54mm',
                    name: 'productSize[]',
                    class: 'productSize',
                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '54mm',

                }));



                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '55mm',
                    name: 'productSize[]',
                    class: 'productSize',
                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '55mm',

                }));



            }else if(productType.value=='Footwear'){

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '36',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '36',

                }));

                $('#productSize').append($('<br>', { 
                }));



                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '37',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '37',

                }));


                $('#productSize').append($('<br>', { 
                }));



                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '38',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '38',

                }));


                $('#productSize').append($('<br>', { 
                }));


                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '39',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '39',

                }));


                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '40',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '40',

                }));


                $('#productSize').append($('<br>', { 
                }));


                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '41',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '41',

                }));


                $('#productSize').append($('<br>', { 
                }));


                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '42',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '42',

                }));


                $('#productSize').append($('<br>', { 
                }));


                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '43',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '43',

                }));


                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '44',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '44',

                }));


                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '45',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '45',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '46',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '46',

                }));

                $('#productSize').append($('<br>', { 
                }));





            }else if(productType.value=='Watches'){

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '26mm',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '26mm',

                }));

                $('#productSize').append($('<br>', { 
                }));


                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '34mm',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '34mm',

                }));

                $('#productSize').append($('<br>', { 
                }));


                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '36mm',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '36mm',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '39mm',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '39mm',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '40mm',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '40mm',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '42mm',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '42mm',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '44mm',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '44mm',

                }));

                $('#productSize').append($('<br>', { 
                }));

            }else{

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: 'XS',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: 'XS',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: 'Small',
                    name: 'productSize[]',
                    class: 'productSize',


                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: 'Small',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: 'Medium',
                    name: 'productSize[]',
                    class: 'productSize',

                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: 'Medium',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: 'Large',
                    name: 'productSize[]',
                    class: 'productSize',

                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: 'Large',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: 'XL',
                    name: 'productSize[]',
                    class: 'productSize',

                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: 'XL',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '2XL',
                    name: 'productSize[]',
                    class: 'productSize',

                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '2XL',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '3XL',
                    name: 'productSize[]',
                    class: 'productSize',

                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '3XL',

                }));

                $('#productSize').append($('<br>', { 
                }));

                $('#productSize').append($('<input>', {
                    type: 'checkbox',
                    value: '4XL',
                    name: 'productSize[]',
                    class: 'productSize',

                }));

                $('#productSize').append($('<span>', {

                    html:"&nbsp;"

                }));

                $('#productSize').append($('<label>', {

                    text: '4XL',

                }));

                $('#productSize').append($('<br>', { 
                }));

            }


        }
    </script>


</html>