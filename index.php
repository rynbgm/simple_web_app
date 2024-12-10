<?php
session_start();

include("connection.php");
include("function.php");

$message ="";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (!empty($username)  && !empty($password)) {

    $query = "SELECT * FROM USER WHERE USERNAME='$username' AND PASSWORD='$password' LIMIT 1";
    $result = $con->query(($query));
    if ($result) {

      if ($result && mysqli_num_rows($result) > 0) {
        $user_data = $result->fetch_assoc();
        if ($user_data['PASSWORD'] == $password && $user_data['USERNAME'] == $username && $user_data['TYPE'] == "Admin") {
          $_SESSION['USERNAME'] = $user_data['USERNAME'];
          $_SESSION['FIRSTNAME'] = $user_data['FIRSTNAME'];
          $_SESSION['LASTNAME'] = $user_data['LASTNAME'];
          $_SESSION['TYPE'] =$user_data['TYPE'];
          header("Location: admin/acceuil.php");
          die;
        }
        else if($user_data['TYPE'] == "Student"){
          $_SESSION['ID'] = $user_data['ID'];
          $_SESSION['USERNAME'] = $user_data['USERNAME'];
          $_SESSION['FIRSTNAME'] = $user_data['FIRSTNAME'];
          $_SESSION['LASTNAME'] = $user_data['LASTNAME'];
          $_SESSION['TYPE'] =$user_data['TYPE'];
          header("Location: student/acceuil.php");
          die;
        }
        } else {
          $message = "WRONG INFO!";
        }
      }
    }
  }
?>


<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin</title>
    <link rel="stylesheet" href="./Styles/index.css">


</head>

<body>
    <header>
        <h1>Your online Library</h1>
        <img src="./Assets/logo.png">
    </header>
    <div class="formulaire">
        <form method="post">
            <p>Login to your account</p>
            <?php if($message != ""){ ?>
                <div class ="error"><?php echo $message; ?></div>
               <?php }?>
            <label for="username"><strong>Username</strong></label>
            <input type="text" name="username" id="username" required><br>

            <label for="password"><strong>Mot de passe</strong></label>
            <input type="password" name="password" id="password" required><br>

            <input type="submit" name="signin" value="Connect"/>
        </form>
    </div>
    <footer>
        <div class="copyright">
            <p>&copy; 2024 L2 INFO. All rights reserved.</p>
        </div>
        <div class="contact">
            <p>Contact us :</p>
            <ul>
                <!-- rajoute ton mail ici -->
                <li><a href="mailto:elie.@univ_rouen.fr">elie.@univ_rouen.fr</a></li>
                <li><a href="mailto:rayan.boughanem@univ_rouen.fr">rayan.boughanem@univ_rouen.fr</a></li>
            </ul>
        </div>
    </footer>
</body>

</html>