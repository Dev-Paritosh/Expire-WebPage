<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: admin_login.php");
}
include("config.php");

?> 


<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/admin_style.css">

  <script src="https://kit.fontawesome.com/ce39fda112.js" crossorigin="anonymous"></script>
  <title>Teaching Hub</title>

  <?php
        // include("config.php");
     
        if(isset($_POST['but_upload'])){
            $maxsize = 52428800000; // 50000MB
                       
            $name = $_FILES['file']['name'];
            $target_dir = "videos/";
            $target_file = $target_dir . $_FILES["file"]["name"];

            // Select file type
            $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

            // Check extension
            if( in_array($videoFileType,$extensions_arr) ){
                
                // Check file size $ 
                if( ($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0) ){
                    echo "File too large. File must be less than 5MB.";
                }else{
                    // Upload
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
                        // Insert record
                        $query = "INSERT INTO videos(name,location) VALUES('".$name."','".$target_file."')";

                        mysqli_query($conn,$query);
                        echo '<script>alert("Uploaded Successfully")</script>';
                    }
                }

            }else{
                echo "Invalid file extension.";
            }
        
        }
        ?>
</head>

<body>
  
  <div class="logout">
    <a class="nav-link" href="logout.php">Logout  <img id="logout_img" src="images/logout.png"> </a>
  </div>
  <div class="user">
    <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png"> Admin Prevelige Access</a>
  </div>
    <div class="row to_do">
        <div class="col-lg-12 col-sm-12">
        <a href="uploadvideos.php"><i class="fas fa-cloud-upload-alt fa-10x" title="Upload"></i></a>
        </div>
        <div class="col-lg-12 col-sm-12">
        <form method="post" action="" enctype='multipart/form-data'>
            <input type='file' name='file' />
            <input type='submit' value='Upload' name='but_upload'>
        </form>
        </div>
        
        
    </div>
    <!-- <div class="row to_do_dis text-primary">
        <div class="col-lg-6">
        <a href="uploadvideos.php">Upload</a> 
        </div>
         <div class="col-lg-6">
           <a href="readvideos.php">View Vedio</a> 
        </div> 
    </div> -->

  

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>