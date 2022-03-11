<?php
session_start();
unset($_SESSION["user"]);
setcookie("rememberMe" , $_POST["email"], time() - 8600*30 );
header("location:login.php");
