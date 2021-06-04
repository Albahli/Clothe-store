<?php
session_start();

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
$i;
if(isset($_POST['customerUsername']))
{

    $customerUsername = $_POST['customerUsername'];

    if(isset($_POST['email']) && $_POST['email']!="")
    {
        $email = $_POST['email'];

        $query1 = $conn->prepare("UPDATE Customer SET email=? WHERE userName = ?;");
        $query1->bind_param('ss', $email, $customerUsername); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_POST['phoneNumber']) && $_POST['phoneNumber']!="")
    {
        $phoneNumber = $_POST['phoneNumber'];

        $query1 = $conn->prepare("UPDATE Customer SET phoneNumber=? WHERE userName = ?;");
        $query1->bind_param('ss', $phoneNumber, $customerUsername); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_POST['password']) && $_POST['password']!='')
    {
        $password = $_POST['password'];

        $query1 = $conn->prepare("UPDATE Customer SET password=? WHERE userName = ?;");
        $query1->bind_param('ss', $password, $customerUsername); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_POST['city']) && $_POST['city']!='')
    {
        $city = $_POST['city'];

        $query1 = $conn->prepare("UPDATE Customer SET city=? WHERE userName = ?;");
        $query1->bind_param('ss', $city, $customerUsername); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_POST['address']) && $_POST['address']!='')
    {
        $address = $_POST['address'];

        $query1 = $conn->prepare("UPDATE Customer SET address=? WHERE userName = ?;");
        $query1->bind_param('ss', $address, $customerUsername); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(!empty($i))
    {
    header("Location: profile.php?Profile=Updated");
    exit();
    }
    else
    {
    header("Location: profile.php?Profile=NotUpdated");
    exit();
    }
}
else
{
    echo 'customer username not set';
}
?>