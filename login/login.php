<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: welcome.php");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: welcome.php");
                            
                        }
                    }

                }

    }
}    


}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- External Css -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- Google Font Ingerit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Monda&family=Montserrat:wght@500&display=swap" rel="stylesheet">

</head>

<body>


    <div class="boxa">
        <div id="iheading">
            <h1>Welcome Back ):</h1>

        </div>

        <div id="log">
            <h1>LogIN Your Account</h1>

        </div>



        <form action="" method="post">
        <div class="row row1">
            <div class="col-lg-4">
                User Name:
            </div>
            <div class="col-lg-8">
                <input class="form-control" name="username" type="text" placeholder="Enter User Name" required  autofocus>
            </div>
        </div>

        <div class="row row1">
            <div class="col-lg-4">
                Password:
            </div>
            <div class="col-lg-8">
                <input class="form-control" name="password" type="password" placeholder="Password" required>
            </div>
        </div>

        <div class="btnLogIn">
            <button type="submit" class="btn btn-primary btn-md">Log IN</button>
        </div>
        </form>
        <div class="extra">
            <p><a href="admin_login.php">Admin Login</a> </p>
            <p><a href="register.php"> New? Register YourSelf</a></p>
        </div>
        









    </div>

    <div class="boxa2">

        <h1 id="iheading1">Welcome to Teaching Hub</h1>

        <div class="row">
            <div class="col-lg-4">
                <img src="images/images.png" alt="Teaching hub">
            </div>
            <div class="col-lg-8">
                <h3 class="about">What is this all about?</h3>
                
                
            </div>
        </div>
        <div class="content">

            <p class="intro">We provide the service across the world to the Teacher's out there to better interract with Student's.</p>
            <div class="list">
                <ul type="none">
                    <li>Register YourSelf</li>
                    <li>LogIN YourSelf</li>
                    <li>Upload Vedio</li>
                    <li>Watch Vedio</li>
                </ul>
            </div>
             </div>
        
    </div>


</body>
<!-- <footer id="ifooter">
    Copyright 2021 Paritosh
</footer> -->

</html>
