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
            </div>
        </nav>

        <div class="container text-center" style="padding-top: 10px; padding-bottom:10px">
            <p style="padding-top:20px;"><a href="login.php" class="text-muted" >Have an Account Already ?</a> </p>


            <ul class="nav nav-tabs m-auto nav-fill" id="myTab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="true">Register New User</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="Designer-tab" data-toggle="tab" href="#Designer" role="tab" aria-controls="Designer" aria-selected="false">Register New Designer</a>
                </li>

            </ul>



            <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">

                    <form action="registerCustomer.php" method="post" id= "userForm" class="container" style="padding-top: 20px ;max-width: 60%;" dir="ltr">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="customerUsername" required>
                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="Password">Password</label>
                                <input type="password" class="form-control" name="password" onkeyup= "checkUserPass()" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="ConfirmPassword">Confirm Password</label>
                                <small id ='passwordError' class="passwordError" style="color: red; font-size: 10px; display: none ">&nbsp Password does not match</small>
                                <input type="password" class="form-control" id="ConfirmPassword" onkeyup= "checkUserPass()" required>
                            </div>

                        </div>


                        <div class="form-group">
                            <label for="adderss">City</label>
                            <input type="text" class="form-control" name="customerCity" placeholder="Riyadh" required>
                        </div>

                        <div class="form-group">
                            <label for="Address">Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Al Malqa, street 206" required>
                        </div>

                        <div class="form-group">
                            <label for="ContactNumber">Contact Number</label>
                            <input type="tel" class="form-control"  name="customerContactNumber" placeholder="059999999" required>
                        </div>


                        <button id="z" type="submit" class="btn btn-primary">Sign Up</button>

                        <?php 

                        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                        if(strpos($url, "signup=successCustomer") == true){

                            echo "<div class='alert alert-success' role='alert' style='margin-top:20px; '>
 You have successfully registered, <a href='login.php' class='alert-link'>login here</a>. </div>";
                        }
                        else if (strpos($url, "signup=errorCustomerUsername") == true){

                            echo "<div class='alert alert-danger' role='alert' style='margin-top:20px; '>
 Username is already taken. </div>";
                        }

                        else if (strpos($url, "signup=errorCustomerEmail") == true){

                            echo "<div class='alert alert-danger' role='alert' style='margin-top:20px; '>
Email is already taken. </div>";
                        }

                        ?>
                    </form>



                </div>


                <div class="tab-pane fade" id="Designer" role="tabpanel" aria-labelledby="Designer-tab">

                    <form id="designerForm" action="registerDesigner.php" method="post" class="container" style="padding-top: 20px; max-width: 60%;" dir="ltr">


                        <div class="form-row" >

                            <div class="form-group col-md-6">
                                <label for="designerEmail" >Email</label>
                                <input type="email" class="form-control" name="designerEmail" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="designerUsername">Username</label>
                                <input type="text" class="form-control" name="designerUsername">
                            </div>

                        </div>


                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="designerPassword">Password</label>
                                <input type="password" class="form-control" name="designerPassword" onkeyup= "checkDesignerPass()" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="DesignerPasswordError">Confirm Password</label>
                                <small id ='DesignerPasswordError' class="DesignerPasswordError" style="color: red; font-size: 10px; display: none ">&nbsp Password does not match</small>
                                <input type="password" class="form-control" id="designerConfirmPassword" onkeyup= "checkDesignerPass()" required>
                            </div>

                        </div>





                        <div class="form-group">
                            <label for="BrandName">Brand Name</label>
                            <input type="text" class="form-control" name="brandName" placeholder="Nike">
                        </div>


                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="designerCity">City</label>
                                <input type="text" class="form-control" name="designerCity" placeholder="Riyadh">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="designerContactNumber">Contact Number</label>
                                <input type="text" class="form-control" name="designerContactNumber" placeholder="059999999">
                            </div>


                        </div>

                        <button type="submit" class="btn btn-primary">Sign Up</button>


                        <?php 

                        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                        $designerTab = false;
                        if(strpos($url, "signup=successDesigner") == true){

                            echo "<div class='alert alert-success' role='alert' style='margin-top:20px; '>
 You have successfully registered as designer, <a href='login.php' class='alert-link'>login here</a>. </div>";
                            $designerTab = true;

                        }
                        else if (strpos($url, "signup=errorDesignerUsername") == true){

                            echo "<div class='alert alert-danger' role='alert' style='margin-top:20px; '>
 Username is already taken. </div>";

                            $designerTab = true;
                        }

                        else if (strpos($url, "signup=errorDesignerEmail") == true){

                            echo "<div class='alert alert-danger' role='alert' style='margin-top:20px; '>
Email is already taken. </div>";

                            $designerTab = true;
                        }

                        ?>




                    </form>



                </div>


            </div>









        </div>









        <!-- Footer -->
        <footer class="page-footer bg-light  font-small ">
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

            <?php
            if($designerTab)
                echo "$('#myTab li:last-child a').tab('show');"; 
            ?>



            function checkUserPass(){

                let password = document.getElementById("Password").value;
                let confirmedPassword = document.getElementById("ConfirmPassword").value;

                if(password != null){
                    if(password.length != confirmedPassword.length || confirmedPassword===''){

                        $('#passwordError').show();
                        return;
                    } 



                    if(confirmedPassword.length>password.length){
                        $('#passwordError').show();
                        return;
                    }

                    for(let i = 0; i<password.length ; i++){
                        if(password[i] != confirmedPassword[i]){

                            $('#passwordError').show();
                            return;
                        }

                    }
                    $('#passwordError').hide();


                }
            }




            function checkDesignerPass(){



                let password = document.getElementById("designerPassword").value;
                let confirmedPassword = document.getElementById("designerConfirmPassword").value;

                if(password != null)
                    if(password.length != confirmedPassword.length || confirmedPassword===''){

                        $('#DesignerPasswordError').show();
                        return;
                    } 



                if(confirmedPassword.length > password.length){
                    $('#DesignerPasswordError').show();
                    return;
                }

                for(let i = 0; i<password.length ; i++){
                    if(password[i] != confirmedPassword[i]){

                        $('#DesignerPasswordError').show();
                        return;
                    }

                }
                $('#DesignerPasswordError').hide();



            }


        </script>

    </body>


</html>