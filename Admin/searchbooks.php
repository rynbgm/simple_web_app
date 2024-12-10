<?php
session_start();
include("../connection.php");
include("../function.php");
check_login();

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
<div class = "buttons"><div class="add"><a href="acceuil.php"><button>Go Back</button></a></div><div class="add"><a href="../logout.php"><button class="remove">Log Out</button></a></div>
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
        echo " <form id ='". $items["BookId"]."' method='get' action='editbook.php?idbook=". $items["BookId"]."' class='book'><input type='hidden' name='idbook' value='"
        . $items["BookId"]."'>
        <h2>".$items["Title"]."</h2>
        <p class='author'> by ". $items["Publisher"]."</p>
        <p class='availability'>Release year: ".$items["Year"] . "</p>
        <p class='availability'>Availabilty: ".$items["Availability"] . "</p>
        <p class='description'>This is a brief description of the book to give potential readers an idea of what it's
            about.</p>
            <input type='submit' value='Edit'></> <a href='acceuil.php?idbook=". $items["BookId"]."' class='del'>Remove</a>
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