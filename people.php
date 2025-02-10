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
    <h1 style="text-align: center;">InstaClone</h1>
    <p style="text-align: center;">Add a New Follower</p>
    <?php
    $followers_count = getPeopleFollowingMe($_SESSION["logged_id"]);
    $following_count = getPeopleIFollow($_SESSION["logged_id"]);
    echo "<p style=\"text-align: center;\">Followers: $followers_count - Following: $following_count - <a href=\"feed.php\">Your feed</a> - <a href=\"profile.php?userid=" . $_SESSION["logged_id"] . "\">Your profile</a> - <a href=\"logout.php\">Log out</a></p>";

    ?>
    <form method="POST" action="people.php">
        <label for="seguir">Nombre de usuario a seguir:</label>
        <input type="text" id="seguir" name="seguir" required>
        <button type="submit">Add follower</button>
    </form>

    <?php
    //para seguir a alguien nuevo, insertar en tabla followers. follower_id es el usuario actual, following_id sera el id del usuario que se va a seguir
    $conn = getDbConnection();
    // Verificar si se recibió el nombre del usuario a seguir desde un formulario
    if (isset($_POST['seguir'])) {
        $username_to_follow = $_POST['seguir'];
        $follower_id = $_SESSION['logged_id']; //$_SESSION['user_id'];  // ID del usuario logueado
    
        // Obtiene el ID del usuario a seguir y verifica si existe
        $sql = "SELECT id FROM users WHERE username = '$username_to_follow'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $following_id = mysqli_fetch_assoc($result)['id'];

            // Verificar si ya sigue a este usuario
            $check_sql = "SELECT 1 FROM followers WHERE follower_id = $follower_id AND following_id = $following_id";
            $check_result = mysqli_query($conn, $check_sql);

            if ($check_result && mysqli_num_rows($check_result) === 0) {
                // Insertar en la tabla followers si no se sigue al usuario
                $insert_sql = "INSERT INTO followers (follower_id, following_id) VALUES ($follower_id, $following_id)";
                if (mysqli_query($conn, $insert_sql)) {
                    echo "Ahora sigues a $username_to_follow.";
                } else {
                    echo "Error al seguir usuario: " . mysqli_error($conn);
                }
            } else {
                echo "Ya sigues a este usuario";
            }
        } else {
            echo "El usuario no existe";
        }
    } else {
        echo "La casilla no puede estar vacia";
    }
    ?>
    <p>Followers</p>
    <ul>
        <?php
        //para seguir a alguien nuevo, insertar en tabla followers. follower_id es el usuario actual, following_id sera el id del usuario que se va a seguir
        $sql = "SELECT u.id, u.username FROM followers f JOIN users u ON f.follower_id = u.id 
        WHERE f.following_id = " . $_SESSION['logged_id'] . " ORDER BY u.username DESC"; //1 deberia ser la id de la sesion
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>" . htmlspecialchars($row["username"]) . "</li>";
            }
        }
        ?>
    </ul>

    <p>Following</p>
    <ul>
        <?php
        //para seguir a alguien nuevo, insertar en tabla followers. follower_id es el usuario actual, following_id sera el id del usuario que se va a seguir
        $sql = "SELECT u.id, u.username FROM followers f JOIN users u ON f.following_id = u.id 
    WHERE f.follower_id = " . $_SESSION['logged_id'] . " ORDER BY u.username DESC"; //1 deberia ser la id de la sesion
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>" . htmlspecialchars($row["username"]) . "</li>";
            }
        }

        ?>
    </ul>
</body>

</html>