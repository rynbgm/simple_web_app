<?php
session_start();
include("../connection.php");
include("../function.php");
check_login();

if(isset($_GET['idbook'])){
    $idbook = $_GET['idbook'];
    $deletebook = "DELETE FROM BOOK WHERE BookId = '$idbook'";
    $con->query($deletebook);
    echo "<script>alert('Book deleted succesfully.')</script>";
}


if(isset($_GET['iduser'])){
    $iduser = $_GET['iduser'];
    $deleteuser = "DELETE FROM USER WHERE ID = '$iduser'";
    $con->query($deleteuser);
    echo "<script>alert('User deleted succesfully.')</script>";
}


$query = "SELECT * FROM USER";
$result = $con->query($query);

$querybook = "SELECT * FROM BOOK";
$resultbook = $con->query($querybook);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/acceuil.css">
    <title>Document</title>
    <script>
function navigateToSection(sectionId) {
    if (sectionId !== "") {
        window.location.hash = sectionId;
    }
    document.getElementById('navigationDropdown').value = "";
}
</script>
</head>
<body>
    <div>
    <nav class="navbar">
        
        <p class="txt"><strong>First Name</strong>: <?php echo $_SESSION['FIRSTNAME'];?></p>
        <p class="txt"><strong>Last Name</strong>: <?php echo $_SESSION['LASTNAME'];?></p>
        <p class="txt"><strong>Email</strong>: <?php echo $_SESSION['USERNAME'];?></p>
        <p class="txt"><strong>Status</strong>: <?php echo $_SESSION['TYPE'];?></p>
        <select id="navigationDropdown" onchange="navigateToSection(this.value)">
    <option value="">-- Select a Section --</option>
    <option value="#section1">Go to users</option>
    <option value="#section2">Go to books</option>
</select>

</nav>
    </div>
<div class="add" id="section1"><a href="addmember.php"><button>Add member</button></a> <a href="../logout.php"><button class ="remove">Log Out</button></a></div>
<div class="search">
    <form action="searchuser.php" method="get" class="search_bar">
      <input type="text" placeholder="Search All Users" name="search" class="search_bar" autocomplete="off">
      <button type="submit" name="submit" class="search_bar">Search</button>
    </form>
</div>
<div><table border = 3px>
    <tr>
    <th> First Name</th>
    <th>Last Name</th>
    <th>Date of Birth</th>
    <th>Email</th>
    <th>Type</th>
    <th>Action</th>
    </tr>
    <tbody>      
   <?php while($row = mysqli_fetch_assoc($result)) {
        echo "<form method = 'get' action= 'edituser.php'><tr><td>" ."<input type='hidden' name= 'iduser' " 
        . " value=". $row["ID"] ."/>". $row["FIRSTNAME"] ."</td><td>" . $row["LASTNAME"] . "</td><td>" .$row["DATEOFBIRTH"]. "</td><td>" . $row["USERNAME"] . "</td><td>" . $row["TYPE"] ."</td><td><input type= 'submit' value = 'Edit'/>" 
        ."<a href='acceuil.php?iduser=". $row['ID'] 
        ."' class= 'del'>Remove</a>" . "</td></tr></form>";

    }
?>
    </tbody>
</table>
</div>

<div class="add" id="section2"><a href="addbook.php"><button>Add Book</button></a></div>

<div class="search">
<form action="searchbooks.php" method="get" class="search_bar">
      <input type="text" placeholder="Search Books" name="search" class="search_bar" autocomplete="off">
      <button type="submit" name="submit" class="search_bar">Search</button>
    </form>
</div>
<div class="bookcontainer">
   <?php
   while($row = mysqli_fetch_assoc($resultbook)) {
        echo " <form  method='get' action='editbook.php?idbook=". $row["BookId"]."' class='book'><input type='hidden' name='idbook' value='"
        . $row["BookId"]."'>
        <h2>".$row["Title"]."</h2>
        <p class='author'> by ". $row["Publisher"]."</p>
        <p class='availability'>Release year: ".$row["Year"] . "</p>
        <p class='availability'>Availabilty: ".$row["Availability"] . "</p>
             <input type='submit' value='Edit'></> <a href='acceuil.php?idbook=". $row["BookId"]."' class='del'>Remove</a>
    </form>";

    }
    ?>
    
</div>
</body>
</html>