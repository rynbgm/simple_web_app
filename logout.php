<?php
session_start();

include("connection.php");
session_unset();
session_destroy();
header("Location: index.php");
die;
