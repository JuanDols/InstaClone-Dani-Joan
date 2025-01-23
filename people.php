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
    <p>Add a New Follower</p>
    <?php
    //TODO @joan hacer estructura - manage people
    //para seguir a alguien nuevo, insertar en tabla followers. follower_id es el usuario actual, following_id sera el id del usuario que se va a seguir

    ?>
    <p>Followers</p>
    <?php
    //TODO @joan hacer estructura - manage people
    //para seguir a alguien nuevo, insertar en tabla followers. follower_id es el usuario actual, following_id sera el id del usuario que se va a seguir
    
    ?>
    <p>Following</p>
    <?php
    //TODO @joan hacer estructura - manage people
    //para seguir a alguien nuevo, insertar en tabla followers. follower_id es el usuario actual, following_id sera el id del usuario que se va a seguir


    $sql = 'SELECT ph.user_id, us.username, ph.file_path, ph.caption, ph.created_at FROM instagram_clone.photos ph JOIN users us ON ph.user_id = us.id WHERE user_id = '.$_SESSION["logged_id"].' ORDER BY created_at DESC';
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                //recorrer resultado de la consulta con $row["nombre columna"]
            }
        }
    ?>
</body>
</html>

