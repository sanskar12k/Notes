<?php
    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $database = "notes";
    
    // $conn = mysqli_connect($servername, $username, $password, $database);
    // if(!$conn){
    //     die("Sorry,couldn't connect".mysqli_connect_error());
    // }
    // else{
    // echo"connected";    
    // }
   
    $userExist = false;
    $passwordMatch = true;

    include 'conn.php';
      if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $email = $_POST['email'];
          $password = $_POST['password'];
          $sql = "SELECT * FROM `userdatanotes` WHERE `email` = '$email'";
          $res = mysqli_query($conn, $sql);
          $num = mysqli_num_rows($res);
          if($num == 1){
              $row = mysqli_fetch_assoc($res);
              if(password_verify($password, $row['password'])){
                echo "Logged In";
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $row['name'];
                $_SESSION['email'] = $email;
                header("location:index.php");
                echo"Hello".$_SESSION['username'];

              }
              else{
                $passwordMatch = false;
              }
             

          }
          else{
            $userExist = true;
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

    <title> Login</title>
  </head>
  <body>
     
      <h1 class="text-center">Log In</h1>
      <div class="container w-75">
  <form action = "login.php" method = "post" >
   <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" name = "email" aria-describedby="emailHelp">
   <?php
    if($userExist){
     echo"<div id='emailHelp' class='mx-2 text-danger'>User doesn't exist</div>";
   }
   ?>
    
  </div>

  <div class="mb-3">
  <label for="inputPassword5" class="form-label">Password</label>
<input type="password" id="password" name = "password" class="form-control" aria-describedby="passwordHelpBlock">
<?php
    if(!$passwordMatch){
     echo"<div id='emailHelp' class='mx-2 text-danger'>Incorrect  password</div>";
   }
   ?>
<!-- <div id="emailHelp" class="mx-2 text-danger"></div>  -->
</div>
  <button type="submit" class="btn btn-primary">Submit</button>
  <button onclick="location.href='signup.php'" class="btn btn-primary mx-2"> Sign Up</button>
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