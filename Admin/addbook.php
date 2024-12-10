<?php
session_start();

include("../connection.php");
include("../function.php");
check_login();
$message = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $title = $_POST['title'];
  $publisher = $_POST['publisher'];
  $year = $_POST['year'];
  $availability = $_POST['availability'];

  if (!empty($title) && !empty($publisher) && !empty($year)) {

    //Check if email is already registered
    $query = "SELECT * FROM BOOK WHERE Title='$title' AND Publisher='$publisher' AND Year='$year' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $message = "This book already exists.";
    } else {
      $query = "INSERT INTO BOOK (Title, Publisher, Year, Availability) VALUES('$title','$publisher','$year','$availability')";
      $result = mysqli_query($con, $query);

      echo '<script>alert("Book added");</script>';
      echo '<meta http-equiv="refresh" content="0.01;url=acceuil.php">';
    }
  } else {
    $message = "Please enter valid information";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Styles/addmember.css">
    <title>Document</title>
    <script src="../Scripts/addbook.js"></script>
</head>
<body>
  <div>
    <h1>Add Book</h1>
    <div><form method="post">
      
        <div>
        <label>Title</label>
          <input type="text" name="title" autocomplete="off" required></input>
          
        </div>
        <div>
        <label>Publisher</label>
          <input type="text" name="publisher" autocomplete="off" required></input>
        </div>
      </div>
      <div>
        <div>
        <label>Year</label>
          <input type="number" class="yearinput" name="year" onchange="validateYear(this)" autocomplete="off" required></input>
        </div>
        <div>
        <label>Availability</label>
          <input type="number" min="0" name="availability" autocomplete="off" required></input>
        </div>
        <div>
      <input type="submit" value="Add"></input></div>


    </form></div>
    <?php if ($message != "") { ?>
      <div class="error"><?php echo $message; ?></div>
    <?php } ?>
  </div>

</body>
</html>