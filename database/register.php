<?php
    session_start();
    
    include('config.php');
        
        

        $sql = "INSERT INTO users(f_name, l_name, u_name, email, password, otp) VALUES('$fName', '$lName', '$username','$email', '$passwordHash', $otp)";

        $query = mysqli_query($conn, $sql);  
        $isRegistered = 0;
            if($query) {
                $_SESSION['status'] = "You are registered successfully !";
                $_SESSION['status-code'] = "success";
                $_SESSION['otp'] = "";

                // echo "<script>";
                // echo "otpPopup();";
                // echo "</script>";

                 // Replace this with your actual condition

                              if ($isRegistered == '0') {
                                echo '<script>';
                              echo '    document.addEventListener("DOMContentLoaded", function() {';
                              echo 'otpPopup();';
                              echo '    });';
                              echo '</script>';
                            }
                
            }else{
                $_SESSION['status'] = "DATA COULD NOT BE INSERTED SUCCESSFULLY !";
                $_SESSION['status-code'] = "error";
                header('Location: \dashboard\pages\sign-up.php');
            }

?>