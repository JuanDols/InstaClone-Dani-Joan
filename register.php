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
    echo '<h1>InstaClone Register New User</h1>';
    echo '<form action="" method="POST">';
    echo 'User: <input type="text" name="register_user"><br>';
    echo 'Password: <input type="password" name="register_password"><br>';
    echo 'Confirm password: <input type="password" name="confirm_register_password"><br>';
    echo '<input type="submit" name="register_submit" value="Register">';
    echo '</form>';
    echo '<form action="index.php" method="POST">';
    echo '<input type="submit" name="register_back" value="Go back">';
    echo '</form>';

    if (isset($_POST["register_submit"])) {
        if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["register_user"])) {
            if ($_POST["register_password"] == $_POST["confirm_register_password"]) {
                //buscar si nombre de usuario ya existe
                $sql = "SELECT username FROM users WHERE username LIKE '" . $_POST["register_user"] . "'";
                $result = execQuery(getDbConnection(), $sql);
                if (mysqli_num_rows($result) == 0) {
                    //usuario no encontrado, se procede a insertar
                    $register_password = password_hash($_POST["register_password"], PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users(username, password) VALUES('" . $_POST["register_user"] . "', '" . $register_password . "')";
                    $result = execQuery(getDbConnection(), $sql);
                    //añadir a base de datos
                    if (!$result) {
                        echo "Error creating user";
                    } else {
                        header('Location: index.php?registered=true');
                        exit();
                    }
                } else {
                    echo "User " . $_POST["register_user"] . " already exists, please choose another username.";
                }
            } else {
                //contraseñas no son iguales
                echo "Passwords do not match.";
            }
        } else {
            //nombre de usuario contiene caracteres invalidos
            echo 'Username is not valid. Only numbers and letters from the english alphabet allowed.';
        }
    }
    ?>
</body>

</html>