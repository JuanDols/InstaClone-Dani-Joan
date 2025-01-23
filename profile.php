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
    <style>
        body {
            text-align: center;
        }

        table {
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid black;
            text-align: left;
        }

        p {
            margin: 2px;
        }
    </style>
</head>
<body>
    <!-- THIS IS FOR OPENING IMAGES FULL SIZE. DO NOT TOUCH -->
    <div id="imageModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.8); z-index: 999;">
        <span onclick="document.getElementById('imageModal').style.display='none'"
            style="position:absolute; top:20px; right:20px; font-size: 30px; color:white; cursor:pointer;">&times;</span>
        <img id="modalImg" style="max-width:100%; max-height:100%; margin:auto; display:block; padding-top:60px;">
    </div>

    <h1>InstaClone</h1>
    <?php
    //profile, es la misma pagina para tu perfil propio y uno ajeno
    if (isset($_SESSION["logged_user"])) {
        echo "<p>Welcome to your profile, " . $_SESSION["logged_user"] . "</p>";
        //Menu items will be here

        //obtener numero de gente que me sigue
        $sql = "SELECT count(follower_id) AS followers FROM instagram_clone.followers WHERE following_id = ".$_SESSION["logged_id"]."; -- gente que me sigue";
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $followers_count = $row["followers"];
            }
        }

        //obtener numero de gente que yo sigo
        $sql = "SELECT count(following_id) AS following FROM instagram_clone.followers WHERE follower_id = ".$_SESSION["logged_id"]."; -- gente que yo sigo";
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $following_count = $row["following"];
            }
        }

        echo "<p>Followers: $followers_count - Following: $following_count - <a href=\"people.php\">Manage followers</a> - <a href=\"feed.php\">Your feed</a> - <a href=\"logout.php\">Log out</a></p>";
        
        //TODO @joan cuadro subir archivos
        //preguntar en clase: donde se subiran los archivos?
        

        //ver fotos del perfil
        //TODO boton eliminar foto y fecha y hora de subida
        $sql = 'SELECT ph.user_id, us.username, ph.file_path, ph.caption, ph.created_at FROM instagram_clone.photos ph JOIN users us ON ph.user_id = us.id WHERE user_id = '.$_SESSION["logged_id"].' ORDER BY created_at DESC';
        $result = execQuery(getDbConnection(), $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            $trcount = 0;
            while ($row = mysqli_fetch_assoc($result)) {
                if ($trcount == 0) {
                    echo "<tr>";
                }
                echo '<td>';
                echo '<a href="javascript:void(0)" onclick="openModal(\'' . 'download.php?file='.$row["file_path"] . '\')">';
                echo '<img src=download.php?file='.$row["file_path"].' width = 200px><br>';
                echo '</a>';
                echo '<p><a href=#>' . htmlspecialchars($row['username']) . '</a></p>';
                echo '<p>' . htmlspecialchars($row['caption']) . '</p>';
                echo '<p>' . htmlspecialchars($row['created_at']) . '</p>';
                echo '</td>';
                $trcount += 1;
                if ($trcount == 3) {
                    echo "</tr>";
                    $trcount = 0;
                }
            }
            echo "</table>";
        }
    }else{
        header('Location: index.php');
        exit();
    }
    ?>
</body>
</html>