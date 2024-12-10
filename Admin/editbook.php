<?php

session_start();

include("../connection.php");
include("../function.php");
check_login();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $id = $_GET["idbook"];
  $sql = "SELECT * FROM BOOK WHERE BookId = '$id'";
  $resultbook = $con->query($sql);
  $row = $resultbook->fetch_assoc();

  if(!$row){
    header("acceuil.php");
    die;
  }

  $title = $row['Title'];
  $publisher = $row['Publisher'];
  $year = $row['Year'];
  $availability = $row['Availability'];
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['idbook'];
    $title = $_POST['title'];
    $publisher = $_POST['publisher'];
    $year = $_POST['year'];
    $availability = $_POST['availability'];

  if (!empty($id) && !empty($title) && !empty($publisher) && !empty($year) && !empty($availability)) {

    //Check if email is already registered
    $query = "SELECT * FROM BOOK WHERE BookId='$id' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      
      $query = "UPDATE BOOK SET Title='$title', Publisher='$publisher', Year='$year', Availability='$availability' WHERE BookId='$id'";
      $result = mysqli_query($con, $query);
      echo '<script>alert("Book edited");</script>';
      echo '<meta http-equiv="refresh" content="0.01;url=acceuil.php">';
      
    }
  }
} 


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/addmember.css">
    <script src="../Scripts/editbook.js"></script>

    <title>Document</title>
</head>
<body>
  <div>
    <h1>Edit Book Info</h1>
    <div><form method="post">
      <input type="hidden" name ="idbook" value="<?php echo $id;?>"/>
        <div>
        <label>Title</label>
          <input type="text" name="title" autocomplete="off" value="<?php echo $title;?>"required></input>
          
        </div>
        <div>
        <label>Publisher</label>
          <input type="text" name="publisher" autocomplete="off" value="<?php echo $publisher;?>" required></input>
        </div>
      </div>
        <div>
      
        <label>Year</label>
          <input class="yearinput" type="number" name="year" onchange="validateYear(this)" autocomplete="off" value="<?php echo $year;?>" required></input>
        </div>
        <div>
        <label>Availability</label>
          <input type="number" min ="0" name="availability" autocomplete="off" value="<?php echo $availability;?>"required></input>
        </div>
        <div>
      <input type="submit"  value="Edit"></input></div>


    </form></div>
  </div>
  
</body>
</html>