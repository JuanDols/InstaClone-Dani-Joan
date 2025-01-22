<?php
session_start();
require 'db_connection.php';
$_SESSION = array(); // destroy all $_SESSION data
setcookie("PHPSESSID", "", time() - 3600, "/");
session_destroy();
header("Location: index.php");
exit();
?>