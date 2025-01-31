<?php
session_start();
require 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    echo "<p>Are you sure you want to delete your account? This action is permanent</p>";
    echo "You will be redirected to the login page upon account deletion.";
    echo "<p>Your account is: ".$_SESSION["logged_user"];
    echo "<form action='deleteuser.php' method='POST'>";
    echo '<input type="submit" name="delete_confirm" value="Delete account">';
    echo "</form>";
    echo "<form action='profile.php?userid=".$_SESSION["logged_id"]."' method='POST'>";
    echo '<input type="submit" name="delete_return" value="Return to your account">';
    echo "</form>";
    if(isset($_POST["delete_confirm"])){
        //delete query
        $sql = "DELETE FROM users WHERE username LIKE '".$_SESSION["logged_user"]."'";
        $result = execQuery(getDbConnection(), $sql);
        if (!$result) {
            echo "Error al eliminar usuario.";
        }
        //usuario eliminado correctamente
        header('Location: logout.php');
        exit();
    }
    ?>
</body>
</html>