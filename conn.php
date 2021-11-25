<?php
$servername = "localhost";
$usename = "root";
$passoword = "";
$database = "notes";

$conn = mysqli_connect($servername, $usename, $passoword, $database);
if(!$conn){
    die("Sorry,couldn't connect".mysqli_connect_error());
}
else{
// echo"connected1";    
}

?>