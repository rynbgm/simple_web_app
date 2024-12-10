<?php 
session_start();

include("../connection.php");
include("../function.php");
check_login();

$query = "SELECT * FROM BOOK ";
$result = $con->query($query);
$itemarrayid = array_column($_SESSION["cart"],"bookid");

if(isset($_POST['remove'])){
   if($_GET['action'] == 'remove'){
    foreach($_SESSION['cart'] as $key => $value){
        if($value['bookid'] == $_GET['id']){
            unset($_SESSION['cart'][$key]);
            echo "<script>window.location = 'cart.php'</script>";
        }
    }
   }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/acceuil.css"/>
    <title>Document</title>
</head>
<>
    <div class="add"><a href="acceuil.php"><button>Go Back</button></a></div>
    <table>
        <?php 
        while ($row = $result->fetch_assoc()) {
            foreach ($itemarrayid as $id) {
                if ($row["BookId"] == $id) { ?>
                    <form method="post" action="cart.php?action=remove&id=<?php echo $row["BookId"];?>"><tr>
                        <td><?= $row["Title"];?></td>
                        <td><?= $row["Publisher"];?></td>
                        <td><?= $row["Year"];?></td>
                        <td><input type="submit" value="Remove" name="remove" class="remove"></input></td>
                    </tr>
                    </form>
              <?php  } ?>
           <?php } ?>
       <?php } ?>
        
    </table>
    <?php if (count($_SESSION['cart']) > 0) { ?>
<div class="add"><a href="confirmcart.php"><button>Confirm Cart</button></a>
<a href="emptycart.php"><button class="empty">Empty Cart</button></a></div>

<?php } ?>
</body>
</html>