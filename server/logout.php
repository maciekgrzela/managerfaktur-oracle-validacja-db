<?php
session_start();
if(isset($_SESSION['logged'])){
    if(isset($_SESSION['logged'])){unset($_SESSION['logged']);}
    if(isset($_SESSION['login_status'])){unset($_SESSION['login_status']);}
    if(isset($_SESSION['user_data'])){unset($_SESSION['user_data']);}
    header("Location: ../templates/login.php");
}
?>