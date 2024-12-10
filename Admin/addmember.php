<?php
session_start();

include("../connection.php");
include("../function.php");
check_login();
$message = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $email = $_POST['email'];
  $birth = $_POST['birth'];
  $password = $_POST['password'];
  $type = $_POST['type'];

  if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($type)) {

    //Check if email is already registered
    $query = "SELECT * FROM USER WHERE USERNAME='$email' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $message = "This email is already registered.";
    } else {
      $query = "INSERT INTO USER (FIRSTNAME, LASTNAME, PASSWORD, DATEOFBIRTH, USERNAME, TYPE) VALUES('$firstname','$lastname','$password','$birth','$email','$type')";
      $result = mysqli_query($con, $query);
      echo '<script>alert("Member added.");</script>';
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
    <script src="../Scripts/addmember.js"></script>
</head>
<body>
  <div>
    <h1>Add member</h1>
    <div><form method="post">
      
        <div>
        <label>First Name</label>
          <input type="text" name="firstname" autocomplete="off" required></input>
          
        </div>
        <div>
        <label>Last Name</label>
          <input type="text" name="lastname" autocomplete="off" required></input>
        </div>
      </div>
      <div>
        <div>
        <label>Email(Username)</label>
          <input type="email" name="email" autocomplete="off" required></input>
        </div>
        <div>
          <label>Date of Birth</label>
          <input type="date" name="birth" required></input>
        </div>
        <div>
        <label>Password</label>
          <input type="password" name="password" autocomplete="off" required></input>
        </div>
        <div>
        <label>Type</label>
        <select name="type">
          <option value="Admin">Admin</option>
          <option value="Student">Student</option>
        </select>
        </div>
        <div>
      <input type="submit"  value="Add"></input></div>


    </form></div>
    <?php if ($message != "") { ?>
      <div class="error"><?php echo $message; ?></div>
    <?php } ?>
  </div>

</body>
</html>