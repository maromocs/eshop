<?php


$servername = "localhost";
$username = "root";
$password = "";

$database = "kataflix";


$conn = mysqli_connect($servername,
            $username, $password, $database);


if($conn) { 
}  
else { 
    die("Error". mysqli_connect_error());  
}  
?> 