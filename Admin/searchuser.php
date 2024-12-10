<?php
session_start();
include("../connection.php");
include("../function.php");
check_login();

if(isset($_GET['iduser'])){
  $iduser = $_GET['iduser'];
  $deleteuser = "DELETE FROM USER WHERE ID = '$iduser'";
  $con->query($deleteuser);
  echo "<script>alert('User deleted succesfully.')</script>";
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
<div class="add"><a href="acceuil.php"><button>Go Back</button></a><button><a href="addmember.php">Add member</a></button></div>
<div class="add">
    <form action="#" method="get" class="search_bar">
      <input type="text" placeholder="Search All Users" name="search" class="search_bar" autocomplete="off">
      <button type="submit" name="submit" class="search_bar">Search</button>
    </form>
</div>
<table border = 3px>
    <tbody>      
    <?php
      if (isset($_GET['search'])) {
        $filtervalues = $_GET["search"];
        $query = "SELECT * FROM USER WHERE FIRSTNAME LIKE '%$filtervalues%' OR LASTNAME LIKE '%$filtervalues%' OR USERNAME LIKE '%$filtervalues%'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
      ?> <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Type</th>
            <th>Action</th>
          </tr>
          <?php
          foreach ($result as $items) {
          ?>
          <form method = 'get' action= 'edituser.php'><input type='hidden' name= 'iduser' value=<?php echo $items['ID'];?>/>
            <tr>
              <td><?= $items['FIRSTNAME']; ?></td>
              <td><?= $items['LASTNAME']; ?></td>
              <td><?= $items['USERNAME']; ?></td>
              <td><?= $items['TYPE']; ?></td>
              <td><input type= 'submit' value = 'Edit'/></form><form method = 'get' action="searchuser.php" style="display: inline-block;">
                <input type='hidden' name= 'iduser' value=<?php echo $items['ID'];?>/><input type="submit" value="Remove" class= 'del'/></form></td>
            </tr>
          <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="6"> No record found</td>
          </tr>
      <?php
        }
      }
      ?>
    </tbody>
</table>
</body>
</html>