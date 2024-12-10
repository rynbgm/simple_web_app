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
<div class = "buttons"><div class="add"><a href="acceuil.php"><button>Go Back to all Books</button></a></div><div class="add"><a href="../logout.php"><button class="remove">Log Out</button></a></div>
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
      if (isset($_GET['search'])) {
        $filtervalues = $_GET["search"];
        $query = "SELECT * FROM BOOK WHERE Title LIKE '%$filtervalues%' OR Publisher LIKE '%$filtervalues%' OR Year LIKE '%$filtervalues%'";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0){
        foreach ($result as $items) {
    $sql="SELECT * FROM record WHERE USERID='$_SESSION[ID]' AND BOOKID='$items[BookId]' LIMIT 1";
    $check = $con->query($sql);
    $rowcheck= mysqli_fetch_assoc($check);
    if($items["Availability"] != 0) {
        if(isset($_SESSION["cart"]) && in_array($items["BookId"], array_column($_SESSION["cart"],"bookid"))){
            $stock = "<p style= 'text-align:center;'>Already in cart</p>";
        }else if($rowcheck){
            $stock = "<p style= 'text-align:center;'>Book already borrowed</p>";
        }else{
        $stock = "<button type='submit' name='add'>Borrow</button>";
        }
    }else{
        $stock = "<p style= 'text-align:center;'>Out of Stock</p>";
    }
    
        echo " <form id ='". $items["BookId"]."' method='post' action='#". $items["BookId"]."' class='book'><input type='hidden' name='BookId' value='"
        . $items["BookId"]."'>
        <h2>".$items["Title"]."</h2>
        <p class='author'> by ". $items["Publisher"]."</p>
        <p class='availability'>Release year: ".$items["Year"] . "</p>
        <p class='availability'>Availabilty: ".$items["Availability"] . "</p>
        <p class='description'>This is a brief description of the book to give potential readers an idea of what it's
            about.</p>
            ". $stock ."
    </form>";
}
    }else{
        echo "<div class='book'><h2>No book found</h2></div>";
    }
}
    ?>
    
</div>
   
</body>
</html>