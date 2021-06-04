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
if(isset($_POST['designerID']))
{

    $designerID = $_POST['designerID'];

    if(isset($_POST['brandName']) && $_POST['brandName']!="")
    {
        $brandName = $_POST['brandName'];

        $query1 = $conn->prepare("UPDATE Designer SET brandName=? WHERE designerID = ?;");
        $query1->bind_param('si', $brandName, $designerID); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_POST['email']) && $_POST['email']!="")
    {
        $email = $_POST['email'];

        $query1 = $conn->prepare("UPDATE Designer SET email=? WHERE designerID = ?;");
        $query1->bind_param('si', $email, $designerID); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_POST['phoneNumber']) && $_POST['phoneNumber']!="")
    {
        $phoneNumber = $_POST['phoneNumber'];

        $query1 = $conn->prepare("UPDATE Designer SET phoneNumber=? WHERE designerID = ?;");
        $query1->bind_param('si', $phoneNumber, $designerID); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_POST['password']) && $_POST['password']!='')
    {
        $password = $_POST['password'];

        $query1 = $conn->prepare("UPDATE Designer SET password=? WHERE designerID = ?;");
        $query1->bind_param('si', $password, $designerID); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_POST['city']) && $_POST['city']!='')
    {
        $city = $_POST['city'];

        $query1 = $conn->prepare("UPDATE Designer SET city=? WHERE designerID = ?;");
        $query1->bind_param('si', $city, $designerID); 
        $query1->execute();
        $query1->close();
        $i++;
    }
    if(isset($_FILES['fileLogo']) && $_FILES['fileLogo']['error'] != UPLOAD_ERR_NO_FILE)
    {
        $file = $_FILES['fileLogo'];

        print_r($file); //<-- prints file's date such as name,tmp_name,size error,type
        // exit();
        $fileName = $_FILES['fileLogo']['name'];
        $fileTmpName = $_FILES['fileLogo']['tmp_name'];
        $fileSize = $_FILES['fileLogo']['size'];
        $fileError = $_FILES['fileLogo']['error'];
        $fileType = $_FILES['fileLogo']['type'];

        $fileExt = explode('.' , $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png','PNG','JPG','JPEG');

        if(in_array($fileActualExt, $allowed))
        {
            if($fileError === 0)
            {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'brandLogos/'. $fileNameNew;

                move_uploaded_file($fileTmpName, $fileDestination);

                $query1 = $conn->prepare("UPDATE Designer SET brandLogo = ? WHERE designerID = ?;");
                $query1->bind_param('si', $fileDestination, $designerID); 
                $query1->execute();
                $query1->close();
                $i++;
            }
            else
            {
                header("Location: designerProfile.php?file=error");
                die();
            }

        }
        else
        {
            print_r($file);
            header("Location: designerProfile.php?file=formatNotSupported");
            die();
        }
    }
    if(!empty($i))
    {
    header("Location: designerProfile.php?Profile=Updated");
    exit();
    }
    else
    {
    header("Location: designerProfile.php?Profile=NotUpdated");
    exit();
    }
}
else
{
    echo 'designerID not set';
}
?>