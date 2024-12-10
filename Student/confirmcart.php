<?php 

session_start();
include("../connection.php");
include("../function.php");
check_login();


$itemarrayid =array_column($_SESSION["cart"],"bookid");
         
        
    foreach ($itemarrayid as $id) {
            $sql = "INSERT INTO record (USERID,BOOKID,BORROWDATE,RETURNDATE) VALUES ('$_SESSION[ID]','$id', NOW(), NOW() + INTERVAL 5 DAY)";
            $sql2="UPDATE BOOK SET Availability = Availability - 1 WHERE BookId='$id'";
            $result = mysqli_query($con, $sql);
            mysqli_query($con,"$sql2");
        }

unset($_SESSION['cart']);
header('Location: acceuil.php');