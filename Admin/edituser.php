<?php

session_start();

include("../connection.php");
include("../function.php");
check_login();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
  $id = $_GET["iduser"];
  $sql = "SELECT * FROM USER WHERE ID = '$id'";
  $resultuser = $con->query($sql);
  $row = $resultuser->fetch_assoc();

  if(!$row){
    header("acceuil.php");
    die;
  }

  $firstname = $row['FIRSTNAME'];
  $lastname = $row['LASTNAME'];
  $email = $row['USERNAME'];
  $birth = $row['DATEOFBIRTH'];
  
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['iduser'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $birth = $_POST['birth'];
    $password = $_POST['password'];
    $type = $_POST['type'];

  if (!empty($id) && !empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($type)) {

   
    $query = "SELECT * FROM USER WHERE ID='$id' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      
      $query = "UPDATE USER SET FIRSTNAME='$firstname', LASTNAME='$lastname', USERNAME='$email',DATEOFBIRTH='$birth', PASSWORD='$password', TYPE='$type' WHERE ID='$id'";
      $result = mysqli_query($con, $query);
      echo '<script>alert("User edited");</script>';
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
    <title>Document</title>
    <script src="../Scripts/addmember.js"></script>
</head>
<body>
  <div>
    <h1>Edit member</h1>
    <div><form method="post">
    <input type="hidden" name ="iduser" value="<?php echo $id;?>"/>
        <div>
        <label>First Name</label>
          <input type="text" name="firstname" value="<?php echo $firstname;?>"autocomplete="off" required></input>
          
        </div>
        <div>
        <label>Last Name</label>
          <input type="text" name="lastname" value="<?php echo $lastname;?>" autocomplete="off" required></input>
        </div>
      </div>
      <div>
        <div>
        <label>Email(Username)</label>
          <input type="email" name="email" value="<?php echo $email;?>" autocomplete="off" required></input>
        </div>
        <div>
          <label>Date of Birth</label>
          <input type="date" name="birth" value="<?php echo $birth;?>" required></input>
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
      <input type="submit" value="Edit"></input></div>


    </form></div>
  </div>

</body>
</html>