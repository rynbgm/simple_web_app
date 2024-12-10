<?php 

session_start();
include("../connection.php");
include("../function.php");
check_login();

unset($_SESSION['cart']);
header('Location: acceuil.php');