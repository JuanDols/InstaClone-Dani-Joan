<?php
session_start();
require "db_connection.php";
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
    //TODO @joan -> enunciado: Protect the site from malicious user input by using htmlspecialchars and mysqli_real_escape_string.

    //TODO aqui con el insert ignore, cada vez que se ejecuta initDatabase, va a insertar las imagenes repetidas (porque no necesita primary key)
    initDatabase();
    #cuando clicamos boton submit, comprobar si el usuario se encuentra en la base de datos
    if (isset($_POST["login_submit"])) {
        $sql = 'SELECT id, username, password FROM instagram_clone.users WHERE username = "' . $_POST['user'] . '"';
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            //TO-DO cambiar este while, mirar si hay algo para recorrer cuando nos devuelve solo una fila
            while ($row = mysqli_fetch_assoc($result)) {
                $hashed_password = $row["password"];
                $user_id = $row["id"];
            }
            if (password_verify($_POST["password"], $hashed_password)) {
                //Inicio de sesion correcto
                $_SESSION["logged_user"] = $_POST["user"];
                $_SESSION["logged_id"] = $user_id;
            } else {
                echo 'Wrong user/password<br>';
            }
        }
    }

    if (isset($_SESSION["logged_user"])) {
        #if session encuentra el usuario, redirigir a pagina feed
        header('Location: feed.php');
        exit();
    } else {
        #if session no encuentra el usuario, cargar login
        echo '<h1>InstaClone Login</h1>';
        echo '<form action="" method="POST">';
        echo 'User: <input type="text" name="user"><br>';
        echo 'Password: <input type="password" name="password"><br>';
        echo '<input type="submit" name="login_submit">';
        echo '</form>';
        echo '<';
    }

    //TODO Only logging in and out is required. If you implement registering and deleting users, you will get an extra point. 
    // si se hace register: Do not allow special characters in usernames when registering. See this: https://stackoverflow.com/questions/32911875/allow-only-english-letters-and-numbers-in-php
    ?>
</body>

</html>