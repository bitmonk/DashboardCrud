<?php 
    session_start();

    session_unset();
    if(session_unset()){
        header("Location: sign-in.php");
    }
?>