<?php 
    $server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "crud_db";


    $conn = mysqli_connect($server, $db_user, $db_password, $db_name);

    if(!$conn){
        die("Something Went Wrong !");
    }

?>