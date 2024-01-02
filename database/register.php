<?php
    session_start();
    
    include('config.php');


        $sql = "INSERT INTO users(f_name, l_name, u_name, email, password) VALUES('$fName', '$lName', '$username','$email', '$passwordHash')";

        $query = mysqli_query($conn, $sql);  
    
            if($query) {
                $_SESSION['status'] = "You are registered successfully !";
                $_SESSION['status-code'] = "success";
                header('Location: \dashboard\pages\sign-in.php');
            }else{
                $_SESSION['status'] = "DATA COULD NOT BE INSERTED SUCCESSFULLY !";
                $_SESSION['status-code'] = "error";
                header('Location: \dashboard\pages\sign-up.php');
            }

?>