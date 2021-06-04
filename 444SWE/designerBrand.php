<?php
session_start();

$host = "localhost";
$dbUsername = "root";
$dpPassword = "";
$dpName = "444SWE";

$conn = new mysqli($host , $dbUsername , $dpPassword , $dpName);
$brandName;
if(mysqli_connect_error())
{
    echo "Failed to connect to database !";
    die();
}
if(isset($_GET['id']))
{
    $designerID = $_GET['id'];
    $sql = "SELECT * FROM Product WHERE productDesignerID=".$designerID.";";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);

    $sqlDesigner = "SELECT * FROM Designer WHERE designerID=".$designerID.";";
    $resultDesigner = mysqli_query($conn,$sqlDesigner);
    $resultDesignerCheck = mysqli_num_rows($resultDesigner);



    if($resultDesignerCheck > 0)
    {
        while($row = mysqli_fetch_assoc($resultDesigner))
        {
            $brandName = $row['brandName'];
        }
    }
}
else
{
    echo "The requested page is not available.";
    die();
}

if(isset($_SESSION['login_user']) )
{

    $loggedUser = $_SESSION['login_user'];

    if(isset($_SESSION['user_type']))
    {
        $userType = $_SESSION['user_type']; // user type : customer , designer
    }
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
            .out-of-stock
            {
                opacity: 0.6;
            }
            .out-of-stock:hover
            {
                opacity: 0.6;

            }
            .out-of-stock .out-of-stock-label
            {
                opacity:1;
                position:absolute;

            }



        </style>




        <title><?php echo $brandName. " | Products" ?> </title>
    </head>

    <body class="font-weight-light" style="font-family: sans-serif">

        <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" style="z-index:2">
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

                    <?php if(isset($userType) && $userType=='customer')
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

}else if(isset($userType) && $userType='designer'){

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

        <div class="container">
            <?php if(isset($brandName)) ;?>
            <h1 class="text-center text-muted p-5 font-weight-light"><?php echo $brandName; ?></h1>  



            <?php

            $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

            if(strpos($url, "product=Deleted") == true){

                echo "<div class='alert alert-success p-2 text-center' role='alert' style='margin-top:20px; '> Product Deleted succesfully. </div>";

                $showMsgModal = true;

            }

            ?>
            <div class="form-inline">
                <div class="input-group mb-3 w-75 mx-auto">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default"><span class="fas fa-search"></span></span>
                    </div>
                    <input type="text" id="search" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" placeholder="Search for product">
                </div> 
                <div class="btn-group float-left border rounded mb-3 genders">
                    <button type="button"  class=" btn btn-light " id="both" value="both" onclick="filterGender(this.id)"><span class="fas fa-venus-mars"></span></button>
                    <button type="button"  class=" btn btn-light " id="male" value="male" onclick="filterGender(this.id)"><span class="fas fa-mars"></span></button>
                    <button type="button"  class="btn btn-light " id="female" value="female" onclick="filterGender(this.id)"><span class="fas fa-venus"></span></button>
                </div>
            </div>
            <hr>
        </div>
        <div class="font-weight-lighter filter">
            <div class="sticky-top btn-group-justified btn-group-vertical  float-left mt-3 ml-3 border  rounded" style="top: 5em ;z-index:1">
                <button type="button" value="All" id="All" class="btn btn-light active" onclick="filter(this.id)">All</button>
                <button type="button" value="Headgear" id="Headgear" class="btn btn-light " onclick="filter(this.id)">Headgear</button>
                <button type="button" value="Scarves" id="Scarves" class="btn btn-light " onclick="filter(this.id)">Scarves</button>
                <button type="button" value="Glasses" id="Glasses" class="btn btn-light " onclick="filter(this.id)">Glasses</button>
                <button type="button" value="SunGlasses" id="SunGlasses" class="btn btn-light " onclick="filter(this.id)">Sun Glasses</button>
                <button type="button" value="Tops" id="Tops" class="btn btn-light " onclick="filter(this.id)">Tops</button>
                <button type="button" value="JacketsCoats" id="JacketsCoats" class="btn btn-light" onclick="filter(this.id)">Jackets / Coats</button>
                <button type="button" value ="Belts" id="Belts" class="btn btn-light " onclick="filter(this.id)">Belts</button>
                <button type="button" value="FullBodyWear" id="FullBodyWear" class="btn btn-light" onclick="filter(this.id)">Full Body Wear</button>
                <button type="button" value="Watches" id="Watches" class="btn btn-light " onclick="filter(this.id)">Watches</button>
                <button type="button" value="Gloves" id="Gloves" class="btn btn-light " onclick="filter(this.id)">Gloves</button>
                <button type="button" value="Bottoms" id="Bottoms" class="btn btn-light " onclick="filter(this.id)">Bottoms</button>
                <button type="button" value="Innerwear" id="Innerwear" class="btn btn-light " onclick="filter(this.id)">Innerwear</button>
                <button type="button" value="Socks" id="Socks" class="btn btn-light " onclick="filter(this.id)">Socks</button>
                <button type="button" value="Footwear" id="Footwear" class="btn btn-light" onclick="filter(this.id)">Footwear</button>
            </div>
            <div class="container">
                <div class="row d-flex flex-row justify-content-around text-center" id="productsList">
                    <?php 
                    if($resultCheck>0)
                    {

                        while($row = mysqli_fetch_assoc($result)){

                            $productType = $row['productType'];
                            if($productType=="Jackets/Coats")
                                $productType= "Jackets-Coats";
                    ?>

                    <div class="<?php echo "Product-type ". $productType ." gender ". $row['productGender'];?> font-weight-light " style="margin-top:25px">
                        <a class="text-muted " href="product.php?<?php echo "Product=".$row['productID']; ?>" style="text-decoration: none;" >
                            <div class="border align-items-center product-card rounded <?php if($row['productQuantity']<1){echo 'out-of-stock';} ?>" style="background-color:#f2f2f2; position:relative">

                                <?php 
                            if($row['productQuantity']<1)
                                echo "<span class='p-2 mt-2 rounded-0 badge badge-danger out-of-stock-label'>Out of stock</span>";
                                ?>


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

                            </div>
                        </a>


                    </div>



                    <?php
                        }

                    }
                    else
                    {
                    ?>

                    <div class="card-body text-center">
                        <div class="alert alert-light" role="alert" style="font-size:25px">
                            Currently there is no products for this brand.
                        </div>
                    </div>



                    <?php
                    }    
                    ?>
                </div>

            </div>   
        </div>
        <div class="empty-space" style="margin-top:700px">

        </div>
        <!-- Footer -->
        <footer class="page-footer  bg-light text-dark font-small  "  style="bottom:0;">
            <hr>
            <!-- Footer Elements -->
            <div class="container">
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
                    $("#productsList .Product-type ").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });

            function filterGender(id)
            {
                let gender = document.getElementById(id).value;

                if(gender == "both")
                {
                    $(".gender").hide();
                    $(".both").show();
                    $('.genders').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(gender == "male")
                {
                    $(".gender").hide();
                    $(".m").show();
                    $('.genders').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(gender == "female")
                {
                    $(".gender").hide();
                    $(".f").show();
                    $('.genders').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";
                } 
            }

            function filter(id)
            {
                let category = document.getElementById(id).value;

                if(category == "All")
                {
                    $(".Product-type").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Headgear")
                {
                    $(".Product-type").hide();
                    $(".Headgear").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Scarves")
                {
                    $(".Product-type").hide();
                    $(".Scarves").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Tops")
                {
                    $(".Product-type").hide();
                    $(".Tops").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Glasses")
                {
                    $(".Product-type").hide();
                    $(".Glasses").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "SunGlasses")
                {
                    $(".Product-type").hide();
                    $(".SunGlasses").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "JacketsCoats")
                {
                    $(".Product-type").hide();
                    $(".Jackets-Coats").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "FullBodyWear")
                {
                    $(".Product-type").hide();
                    $(".Full").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Watches")
                {
                    $(".Product-type").hide();
                    $(".Watches").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Gloves")
                {
                    $(".Product-type").hide();
                    $(".Gloves").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Bottoms")
                {
                    $(".Product-type").hide();
                    $(".Bottoms").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Innerwear")
                {
                    $(".Product-type").hide();
                    $(".Innerwear").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Socks")
                {
                    $(".Product-type").hide();
                    $(".Socks").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";

                }
                else if(category == "Belts")
                {
                    $(".Product-type").hide();
                    $(".Belts").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";
                }
                else if(category == "Footwear")
                {
                    $(".Product-type").hide();
                    $(".Footwear").show();
                    $('.filter').find('button').removeClass("active").end();
                    document.getElementById(id).className = "btn btn-light active";
                }
            }
        </script>
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
        function changeSizes(id)
        {

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