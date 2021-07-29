<?php
require_once "config.php";

$username = $password = $confirm_password = $name = $email ="";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, password, name, email) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_password, $param_name, $param_email);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $param_name = $name;
        $param_email = $email;

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            echo '<script>alert("Registered Successfully")</script>';
            header("location: login.php");
            
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signUp</title>

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- External Css -->
    <link rel="stylesheet" href="css/signUpstyle.css">

    <!-- Google Font Ingerit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@500&display=swap" rel="stylesheet">

</head>

<body>
    
    <div class="boxa">
        <div class="heading">
            <h1>Register YourSelf</h1>
        </div>

        <form action="" class="register" method="post">
            <div class="row">
                <div class="col-lg-4">
                    UserName
                </div>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="username" placeholder="UserName of your Wish" autofocus require>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    Name
                </div>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="name" placeholder="Your Name" require>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    Email
                </div>
                <div class="col-lg-8">
                    <input type="email" class="form-control" name="email" placeholder="Email-Id" require>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    Password
                </div>
                <div class="col-lg-8">
                    <input type="password" class="form-control" name="password" placeholder="Password" require>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    Confirm
                </div>
                <div class="col-lg-8">
                    <input type="text" class="form-control" name="confirm_password" placeholder="Confirm Password" require>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Register</button>
        </form>

        

        <div class="link">
            <a href="login.php">Already a User? LogIN</a>

        </div>
    </div>

    <div class="boxa1">

        <img src="images/registeration.png" alt="">

    </div>




</body>

</html>