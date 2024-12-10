<?php function check_login()
{
  if (!isset($_SESSION['USERNAME'])) {
  header("Location: ../index.php");
  die;
  }
}


