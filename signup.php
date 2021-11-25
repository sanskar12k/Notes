<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";
    
    $conn = mysqli_connect($servername, $username, $password, $database);
    if(!$conn){
        die("Sorry,couldn't connect".mysqli_connect_error());
    }
    else{
    // echo"connected";    
    }
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $username = $_POST['name'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $cpassword = $_POST['cpassword'];
          $sql = "SELECT*FROM `userdatanotes` WHERE `email` = '$email'";
          $res = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($res);
        if($num >=1){
            echo"user Exists";
        }
         else{    
            if($password == $cpassword){
                  $hash = password_hash($password, PASSWORD_DEFAULT);   
                  $sql = "INSERT INTO `userdatanotes` ( `email`, `password`, `date`, `name`) VALUES ( '$email', '$hash', current_timestamp(), '$username')";
                  $result = mysqli_query($conn, $sql);
                  if($result){
                      echo"User Signed Up";
                      header("Location: login.php");
                  }
                  else{
                   echo "Error".mysqli_error($conn);
                  }
              }
              else{
                  echo"Passowrnd nor ";
              }
          }
      }
     
     
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Sign Up</title>
  </head>
  <body>
     
      <h1 class="text-center">Sign Up</h1>
      <div class="container w-75">
  <form action = "signup.php" method = "post" >
 
  <div class="mb-3">
    <label for="exampleInputName" class="form-label">Name</label>
    <input type="text" maxlength="25"class="form-control" id="name" name = "name" aria-describedby="nameHelp">
  </div>
   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" maxlength="30" class="form-control" id="email" name = "email" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
  <label for="inputPassword5" class="form-label">Password</label>
<input type="password" id="password" maxlength="25" minlength="5" name = "password" class="form-control" aria-describedby="passwordHelpBlock">
<div id="passwordHelpBlock" class="form-text">
  Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
</div>
</div>
<div class="mb-3">
  <label for="inputPassword5" class="form-label">Password</label>
<input type="password" id="cpassword" name = "cpassword" class="form-control" aria-describedby="cpasswordHelpBlock">
</div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>