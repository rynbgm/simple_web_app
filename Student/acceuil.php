<?php
session_start();
include("../connection.php");
include("../function.php");
check_login();

$countborrowedbooks = "SELECT COUNT(*) FROM RECORD WHERE USERID='$_SESSION[ID]'";
$countresult = $con->query($countborrowedbooks);
$bookcount = mysqli_fetch_assoc($countresult);
$number = $bookcount['COUNT(*)'];
if(isset($_POST["add"])) {
    if(isset($_SESSION["cart"])){
        if($number >= 5){
            echo "<script>alert('You already borrowed 5 books.')</script>";
        }else{
        if(count($_SESSION['cart']) == 5 || (count($_SESSION['cart'])+$number)==5){
            echo "<script>alert('You can have a total of 5 books between your borrowed ones and in your cart ')</script>";
        }
        else{
            $count = count($_SESSION["cart"]);
            $itemarray = array(
                "bookid" => $_POST['BookId'],
            );
            $_SESSION["cart"][$count] = $itemarray;
        }
    }
    }else{
        if($number >= 5){
            echo "<script>alert('You already borrowed 5 books.')</script>";
        }else{
        $itemarray = array(
            "bookid" => $_POST['BookId'],
        );
        $_SESSION["cart"][0] = $itemarray;
    }
    }
}

    
    

$query = "SELECT * FROM BOOK";
$result = $con->query($query);

$sql="SELECT * FROM record WHERE USERID='$_SESSION[ID]' AND ";


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/acceuil.css">
    <title>Document</title>
</head>
<body>
   <div>
    <nav class="navbar">
        
        <p class="txt"><strong>First Name</strong>: <?php echo $_SESSION['FIRSTNAME'];?></p>
        <p class="txt"><strong>Last Name</strong>: <?php echo $_SESSION['LASTNAME'];?></p>
        <p class="txt"><strong>Email</strong>: <?php echo $_SESSION['USERNAME'];?></p>
        <p class="txt"><strong>Status</strong>: <?php echo $_SESSION['TYPE'];?></p>
</nav>
    </div>
<div class = "buttons"><div class="add"><a href="borrowedbooks.php"><button>Borrowed Books</button></a></div><div class="add"><a href="../logout.php"><button class="remove">Log Out</button></a></div>
<?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) >= 1){ ?>
<div class = "add"><a href="cart.php"><button>Go To Cart</button></a></div>
<?php } ?>
</div>
<div class="search">
<form action="searchbooks.php" method="get" class="search_bar">
      <input type="text" placeholder="Search Books" name="search" class="search_bar" autocomplete="off">
      <button type="submit" name="submit" class="search_bar">Search</button>
    </form>
</div>
<div class="bookcontainer">
   <?php
   while($row = mysqli_fetch_assoc($result)) {
    $sql="SELECT * FROM record WHERE USERID='$_SESSION[ID]' AND BOOKID='$row[BookId]' LIMIT 1";
    $check = $con->query($sql);
    $rowcheck= mysqli_fetch_assoc($check);
    if($row["Availability"] != 0) {
        if(isset($_SESSION["cart"]) && in_array($row["BookId"], array_column($_SESSION["cart"],"bookid"))){
            $stock = "<p style= 'text-align:center;'>Already in cart</p>";
        }else if($rowcheck){
            $stock = "<p style= 'text-align:center;'>Book already borrowed</p>";
        }else{
        $stock = "<button type='submit' name='add'>Borrow</button>";
        }
    }else{
        $stock = "<p style= 'text-align:center;'>Out of Stock</p>";
    }
        echo " <form id ='". $row["BookId"]."' method='post' action='#". $row["BookId"]."' class='book'><input type='hidden' name='BookId' value='"
        . $row["BookId"]."'>
        <h2>".$row["Title"]."</h2>
        <p class='author'> by ". $row["Publisher"]."</p>
        <p class='availability'>Release year: ".$row["Year"] . "</p>
        <p class='availability'>Availabilty: ".$row["Availability"] . "</p>
            ". $stock ."
    </form>";

    }
    ?>
    
</div>
   
</body>
</html>