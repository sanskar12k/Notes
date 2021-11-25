<?php
session_start();
if(!isset($_SESSION['email']) || !$_SESSION['loggedin']){
  header("location:login.php");
  exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet"  href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
   <!-- Icon -->
   <link rel="stylesheet" href="myProjects/webProject/icofont/css/icofont.min.css">
    
   <title>Notes</title>
  </head>
  <body>
      <div class="container">
    <h1 class="text-center" style="text-decoration:underline;"><?php echo $_SESSION['username'];?> Notes</h1>
    <p> Hii <?php echo $_SESSION['username'];?> !!</p>
    <p> Hope you have a good day</p>
    <button onclick="location.href='logout.php'" class="btn btn-primary mx-2"> Log Out</button>
    <?php
    $insert = false;
    $update = false;
    $dele = false;
    //Server connection
    $servername = "localhost";
    $username = "root";
    $password="";
    $db = "notes";

    $conn = mysqli_connect($servername,$username,$password,$db);
    if( !$conn){
        die("Sorry couldn't connect" .mysqli_connect_error());
    }
    else{

    }
   /// TO DELETE A NOTE
    if(isset($_GET['delete'])){
      $sno = $_GET['delete'];
      $sql =  "DELETE FROM `note` WHERE `note`.`S No.` = '$sno'";
      $res = mysqli_query($conn,$sql);
      if($res){
        $dele = true;
        header("Location:/phpTut/Pro1/index.php");
    }
    else{
        echo'<div class="alert alertdanger alert-dismissible fade show" role="alert">
        Deletion Failed
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    }
    }
   /// TO EDIT A NOTE
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      if(isset($_POST['sno'])){
        $Sno = $_POST['sno'];
        $title = $_POST['titleEdit'];
        $detail = $_POST['detailEdit'];
        $deadline = $_POST['deadlineEdit'];
        $newDate = date("Y-m-d", strtotime($deadline));
        $sql = "UPDATE `note` SET `Title` = '$title', `Detail` = '$detail', `Deadline` = '$deadline' WHERE `note`.`S No.` = '$Sno'";
        $res = mysqli_query($conn,$sql);
        if($res){
          $update = true;
      }
      else{
          echo'<div class="alert alertdanger alert-dismissible fade show" role="alert">
          Notes Adding Failed
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
      }
      }
      //TO POST A NOTE
      else{
        $title = $_POST['title'];
        $detail = $_POST['detail'];
        $deadline = $_POST['deadline'];
        $email = $_POST['email'];
        $newDate = date("Y-m-d", strtotime($deadline));
        $sql = "INSERT INTO `note` ( `Title`, `Detail`, `Deadline`,`email`) VALUES ( '$title', '$detail', '$newDate', '$email')";
        $res = mysqli_query($conn,$sql);
        if($res){
            $insert = true;
        }
        else{
            echo'<div class="alert alertdanger alert-dismissible fade show" role="alert">
            Notes Adding Failed' .mysqli_error($conn).'
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
          
        }
      }
      
    }
    ?>

<!-- Modal For Editing -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Notes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="index.php" method = "post" class="w-75">
        <input type="hidden" name = "sno" id = "sno">
    <div class="mb-3 ">
  <label for="formGroupExampleInput" class="form-label">Title</label>
  <input type="text" class="form-control" name = "titleEdit" id="titleEdit" placeholder="Title" required>
</div>
<div class="mb-3">
  <label for="formGroupExampleInput2" class="form-label">Detail</label>
  <textarea rows="4" class="form-control" name = "detailEdit"  id="detailEdit" placeholder="Detail"></textarea>
</div>
<div class="mb-3">
  <label for="formGroupExampleInput2" class="form-label">Deadline</label>
  <input type="date" class="form-control" name = "deadlineEdit" id="deadlineEdit" placeholder="Deadline" required>
</div>
 
<!--Notification-->
  <?php
  if($insert){
      echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
      Notes Added
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    echo "<meta http-equiv='refresh' content='0.5'>";
  }
  elseif( $update){
    echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
    Notes Updated
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
  elseif( $dele){
    echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
    Deleted Successfully
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
  ?>
   <div class="modal-footer">
      <div class="col-12">
    <button type="submit" class="btn btn-primary">Update Note</button>
  </div>
      </div>
</form>
      </div>
     
    </div>
  </div>
</div>

 <!-- To Write a new note-->
    <form action="index.php" method = "post" class="w-75">
    <div class="mb-3 ">
      <input type="hidden" value = <?php echo $_SESSION['email'] ?> name= "email" id="email" />
  <label for="formGroupExampleInput" class="form-label">Title</label>
  <input type="text" class="form-control" name = "title" id="title" placeholder="Title" required>
</div>
<div class="mb-3">
  <label for="formGroupExampleInput2" class="form-label">Detail</label>
  <textarea rows="4" class="form-control" name = "detail"  id="detail" placeholder="Detail"></textarea>
</div>
<div class="mb-3">
  <label for="formGroupExampleInput2" class="form-label">Deadline</label>
  <input type="date" class="form-control" name = "deadline" id="deadline" placeholder="deadline" required>
</div>
<div class="col-12">
    <button type="submit" class="btn btn-success">Add Notes</button>
    <button type="reset" class="btn btn-primary mx-2"> Reset</button>
  </div>
  <?php
  if($insert){
      echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
      Notes Added
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    echo "<meta http-equiv='refresh' content='0.5'>";
  }
  ?>
</form>
<table class="table table-striped" id = "myTable">
  <thead>
    <tr>
      <th scope="col">S No.</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Deadline</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $usermail = $_SESSION['email'];
    $sql = "SELECT * FROM `note` WHERE `email` = '$usermail'";
    $res = mysqli_query($conn, $sql);
    $date = date("Y-m-d");
    // echo $date;
    $bgcol = "white";
  
    if($res){
      $Num = 1;
      while($row = mysqli_fetch_assoc($res)){
        if($date >= $row['Deadline']){
          $bgcol = "#e1505e";
          
        }
        else{
          $bgcol = "#white";

        }
        $newDate = date("d-m-Y", strtotime( $row['Deadline']));
        $newDay = date("l", strtotime( $row['Deadline']));
        
       echo  "<tr style='background-color:".$bgcol.";' >
        <th scope='row'>" . $Num. "</th>
        <td>" .$row['Title']. "</td>
        <td>" .$row['Detail']. "</td>
        <td>" .$row['Deadline']. "</td>
        <td>" .$newDay. "</td>

        <td> <button type='button' class='btn btn-primary edit'data-bs-toggle='modal' id = ".$row['S No.']."data-bs-target='#exampleModal' >Edit</button> 
 <button type='button' class='btn btn-danger del'data-bs-toggle='modal' id = d".$row['S No.']." data-bs-target='#delModal' >Delete</button> </td>
        </tr>";
        // if($bgcol == "#e1505e"){
        //   echo "<strong> Complete this fast </strong>";
        // }
      $Num = $Num+1;
      }
    }
    ?>
  </tbody>
</table>

</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<script> href="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"</script>
   <script>
   $(document).ready( function () {
    $('#myTable').DataTable();
} );
</script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->

    <script>
      edits = document.getElementsByClassName('edit');
      Array.from(edits).forEach(element =>{
        element.addEventListener("click" ,(e)=>{
          console.log("edit");
          title = e.target.parentNode.parentNode.getElementsByTagName("td")[0].innerText;
          description = e.target.parentNode.parentNode.getElementsByTagName("td")[1].innerText;
          deadline = e.target.parentNode.parentNode.getElementsByTagName("td")[2].innerText;
          console.log(title,description);
          titleEdit.value = title;
          sno.value = e.target.id;
          detailEdit.value = description;
          deadlineEdit.value = deadline;
          console.log(e.target.id);
        })
      })

      del = document.getElementsByClassName('del');
      Array.from(del).forEach(element =>{
        element.addEventListener("click" ,(e)=>{
          console.log("delete");
          sno = e.target.id.substr(1,);
          console.log(e.target.id);

          if(confirm("Are you sure to delete?")){
            console.log("yes");
            window.location=`/phpTut/Pro1/index.php?delete=${sno}`;
          };
        })
      })

    </script>
  </body>
</html>